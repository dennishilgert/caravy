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

        $config = $this->container->provide(\Caravy\Core\Configuration::class);
        define('BASE_URL', $config->getGeneralConfig()['baseUrl']);

        $router = $this->container->provide(\Caravy\Routing\Router::class);

        $router->any('index', '\Caravy\Page\PageController@index', 'index');

        $router->get('login', '\Caravy\User\UserController@login', 'login');
        $router->post('login', '\Caravy\User\UserActionHandler@handleLogin');

        $router->get('logout', '\Caravy\User\UserController@logout', 'logout');

        $router->get('user/create', '\Caravy\User\UserController@create');
        $router->post('user/create', '\Caravy\User\UserActionHandler@handleCreate');

        $router->get('user/edit/details/{id}', '\Caravy\User\UserController@editDetails');
        $router->put('user/edit/details', '\Caravy\User\UserActionHandler@handleEditDetails');
        $router->get('user/edit/permissions/{id}', '\Caravy\User\UserController@editPermissions');
        $router->put('user/edit/permissions', '\Caravy\User\UserActionHandler@handleEditPermissions');

        $router->get('user/delete/{id}', '\Caravy\User\UserController@delete');
        $router->delete('user/delete', '\Caravy\User\UserActionHandler@handleDelete');

        $router->get('user/{name}', '\Caravy\User\UserController@profile');

        $router->get('users', '\Caravy\User\UserController@userList', 'users');

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
