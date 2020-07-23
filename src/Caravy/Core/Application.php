<?php

namespace Caravy\Core;

use Caravy\Routing\Request;
use Caravy\Routing\Route;
use Caravy\Support\Arr;

class Application
{
    /**
     * Instance of the instance-factory.
     * 
     * @var \Caravy\Core\Container
     */
    private $container;

    /**
     * Create a new application instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->container = new \Caravy\Container\Container();

        $router = $this->container->provide(\Caravy\Routing\Router::class);

        $router->get('user/create', '\Caravy\User\UserController@create');
        $router->post('user/create', '\Caravy\User\UserController@create');

        $router->get('user/{name}/edit/{id}', '\Caravy\User\UserController@edit');
        $router->put('user/edit', '\Caravy\User\UserController@edit');

        $router->delete('user/delete/{id}', '\Caravy\User\UserController@delete');

        $router->get('user/{name}', '\Caravy\User\UserController@profile');

        $request = new Request('POST', 'user/{name}/edit/{id}');

        $resolver = $this->container->provide(\Caravy\Routing\RouteResolver::class);
        $resolver->match($request);
    }

    /**
     * Get the instance-factory instance.
     * 
     * @return \Caravy\Core\InstanceFactory $instanceFactory
     */
    public function getContainer()
    {
        return $this->container;
    }
}
