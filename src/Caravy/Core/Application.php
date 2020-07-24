<?php

namespace Caravy\Core;

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

        $router->any('index', '\Caravy\Page\PageController@index', 'index');

        $router->get('user/create', '\Caravy\User\UserController@create');
        $router->post('user/create', '\Caravy\User\UserController@create');

        $router->get('user/edit/{id}', '\Caravy\User\UserController@edit');
        $router->put('user/edit', '\Caravy\User\UserController@edit');

        $router->delete('user/delete/{id}', '\Caravy\User\UserController@delete');

        $router->get('user/{name}', '\Caravy\User\UserController@profile');


        $router->handleRequest(\Caravy\Routing\RequestFactory::current());
    }

    /**
     * Get the container instance.
     * 
     * @return \Caravy\Container\Container $container
     */
    public function getContainer()
    {
        return $this->container;
    }
}
