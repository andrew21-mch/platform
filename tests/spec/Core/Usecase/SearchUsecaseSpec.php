<?php

namespace spec\Ushahidi\Core\Usecase;

use Illuminate\Contracts\Translation\Translator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ushahidi\Contracts\Authorizer;
use Ushahidi\Contracts\Entity;
use Ushahidi\Contracts\Formatter;
use Ushahidi\Contracts\Repository\SearchRepository;
use Ushahidi\Core\Tools\SearchData;

class SearchUsecaseSpec extends ObjectBehavior
{
    public function let(
        Authorizer $auth,
        SearchData $search,
        Formatter $format,
        SearchRepository $repo,
        Translator $translator
    ) {
        $format->beADoubleOf('Ushahidi\Core\Tools\Formatter\CollectionFormatter');

        $this->setAuthorizer($auth);
        $this->setData($search);
        $this->setFormatter($format);
        $this->setRepository($repo);
        $this->setTranslator($translator);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Ushahidi\Core\Usecase\SearchUsecase');
    }

    private function tryGetEntity($repo, $entity)
    {
        // Called by SearchUsecase::getEntity
        $repo->getEntity()->willReturn($entity);

        // Called by AuthorizerException
        $entity->getId()->willReturn(0);
        $entity->getResource()->willReturn('widgets');
    }

    public function it_fails_when_authorization_is_denied($auth, $repo, Entity $entity)
    {
        // ... fetch an empty entity
        $this->tryGetEntity($repo, $entity);

        // ... if authorization fails
        $action = 'search';
        $auth->isAllowed($entity, $action)->willReturn(false);

        // ... the exception requests the userid for the message
        $auth->getUserId()->willReturn(1);
        $this->shouldThrow('Ushahidi\Core\Exception\AuthorizerException')->duringInteract();
    }

    public function it_searchs_for_multiple_records($auth, $repo, $format, $search, Entity $entity, Entity $result)
    {
        // ... fetch an empty entity
        $this->tryGetEntity($repo, $entity);

        // ... if authorization passes
        $action = 'search';
        $auth->isAllowed($entity, $action)->willReturn(true);

        // ... it searches for records
        $repo->getSearchFields()->willReturn([]);
        $repo->setSearchParams($search)->shouldBeCalled();

        // ... and gets the results
        $results = [$result];
        $repo->getSearchResults()->willReturn($results);

        // ... and the total count
        $total = 10;
        $repo->getSearchTotal()->wilLReturn($total);

        // ... then filters the results
        $action = 'read';
        $auth->isAllowed($result, $action)->willReturn(true);

        // ... passes the search for paging
        $format->setSearch($search, $total)->shouldBeCalled();

        // ... then formats the records
        $formatted = ['results' => [['id' => 5]], 'total' => $total];
        $format->__invoke($results)->willReturn($formatted);

        // ... and returns the results
        $this->interact()->shouldReturn($formatted);
    }
}
