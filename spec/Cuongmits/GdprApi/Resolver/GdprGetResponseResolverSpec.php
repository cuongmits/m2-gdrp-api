<?php

namespace spec\Cuongmits\GdprApi\Resolver;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Provider\GdprGetRequestResultsProvider;
use Cuongmits\GdprApi\Resolver\GdprGetResponseResolver;

class GdprGetResponseResolverSpec extends ObjectBehavior
{
    function let(GdprGetRequestResultsProvider $resultsItemForGetRequestProvider)
    {
        $this->beConstructedWith($resultsItemForGetRequestProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GdprGetResponseResolver::class);
    }

    function it_should_return_correct_result_with_0_prev_cursor_and_full_query_array_when_full_input_values(
        GdprGetRequestResultsProvider $resultsItemForGetRequestProvider
    ) {
        $requestData = new GdprGetRequestData('firstname', 'lastname', 'email', 'debitor', 'loyalty', 10, 0);
        $uniqueCustomerSets = ['current customer qoc sets'];

        $resultsItemForGetRequestProvider->get($uniqueCustomerSets)->willReturn(['results']);

        $result = $this->getResponse($requestData, $uniqueCustomerSets);

        $result->shouldBeArray();
        $result->shouldHaveKeyWithValue('results', ['results']);
        $result->shouldHaveKeyWithValue('page', [
            'cursor' => [
                'prev' => 0,
                'current' => 0,
                'next' => 10,
            ],
            'size' => 1,
            'limit' => 10,
        ]);
        $result->shouldHaveKeyWithValue('query', [
            'first_name' => 'firstname',
            'last_name' => 'lastname',
            'email_address' =>'email',
            'debitor_number' => 'debitor',
            'debitor_card_number' => 'loyalty',
            'cursor' => 0,
            'limit' => 10
        ]);
    }

    function it_should_return_correct_result_with_not_0_prev_cursor_and_not_full_query_array_when_not_full_input_values(
        GdprGetRequestResultsProvider $resultsItemForGetRequestProvider
    ) {
        $requestData = new GdprGetRequestData('', null, 'email', 'debitor', 'loyalty', 10, 100);
        $uniqueCustomerSets = ['current customer qoc sets'];

        $resultsItemForGetRequestProvider->get($uniqueCustomerSets)->willReturn(['results']);

        $result = $this->getResponse($requestData, $uniqueCustomerSets);

        $result->shouldBeArray();
        $result->shouldHaveKeyWithValue('results', ['results']);
        $result->shouldHaveKeyWithValue('page', [
            'cursor' => [
                'prev' => 90,
                'current' => 100,
                'next' => 110,
            ],
            'size' => 1,
            'limit' => 10,
        ]);
        $result->shouldHaveKeyWithValue('query', [
            'email_address' =>'email',
            'debitor_number' => 'debitor',
            'debitor_card_number' => 'loyalty',
            'cursor' => 100,
            'limit' => 10
        ]);
    }
}
