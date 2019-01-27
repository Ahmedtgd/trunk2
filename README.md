Instruction:
1) Put all relevent routes in one file.
2) Create a middleware for the module.
	 php artisan make:middleware MiddlewareName
e.g. php artisan make:middleware gator

3) Register the middleware in app/http/kernel.php under route middlewares
4) in the routes.php file import the route file created in step 1
	Route::group(['middleware'=>'MiddlewareName'],function(){
		include_once('RouteFileName');
	});

	e.g.
	Route::group(['middleware'=>'gator'],function(){
		include_once('Routes/GatorRoutes.php');
	});

5) Example middleware see, app/Http/Middleware/GatorMiddleware
