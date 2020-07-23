# caravy

PHP Framework

# Notes:

Parse the route URI and normalize / store any implicit binding fields.

@param string \$uri
@return string

protected function parseUri($uri)
{
    $this->bindingFields = [];

    return tap(RouteUri::parse($uri), function ($uri) {
        $this->bindingFields = $uri->bindingFields;
    })->uri;
}


Add a route to the underlying route collection.

@param  array|string  $methods
@param  string  $uri
@param  array|string|callable|null  $action
@return \Illuminate\Routing\Route

public function addRoute($methods, $uri, $action)
{
    return $this->routes->add($this->createRoute($methods, $uri, $action));
}


Create a new Route object.

@param  array|string  $methods
@param  string  $uri
@param  mixed  $action
@return \Illuminate\Routing\Route

public function newRoute($methods, $uri, $action)
{
    return (new Route($methods, $uri, $action))
                ->setRouter($this)
                ->setContainer($this->container);
}


Create a new route instance.

@param  array|string  $methods
@param  string  $uri
@param  mixed  $action
@return \Illuminate\Routing\Route

protected function createRoute($methods, $uri, $action)
{
    // If the route is routing to a controller we will parse the route action into
    // an acceptable array format before registering it and creating this route
    // instance itself. We need to build the Closure that will call this out.
    if ($this->actionReferencesController($action)) {
        $action = $this->convertToControllerAction($action);
    }

    $route = $this->newRoute(
        $methods, $this->prefix($uri), $action
    );

    // If we have groups that need to be merged, we will merge them now after this
    // route has already been created and is ready to go. After we're done with
    // the merge we will be ready to return the route back out to the caller.
    if ($this->hasGroupStack()) {
        $this->mergeGroupAttributesIntoRoute($route);
    }

    $this->addWhereClausesToRoute($route);

    return $route;
}

Add a controller based route action to the action array.

@param  array|string  $action
@return array

protected function convertToControllerAction($action)
{
    if (is_string($action)) {
        $action = ['uses' => $action];
    }

    // Here we'll merge any group "uses" statement if necessary so that the action
    // has the proper clause for this property. Then we can simply set the name
    // of the controller on the action and return the action array for usage.
    if ($this->hasGroupStack()) {
        $action['uses'] = $this->prependGroupNamespace($action['uses']);
    }

    // Here we will set this controller name on the action array just so we always
    // have a copy of it for reference if we need it. This can be used while we
    // search for a controller name or do some other type of fetch operation.
    $action['controller'] = $action['uses'];

    return $action;
}