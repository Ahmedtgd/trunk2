<?php

	Route::get('branch/product/listrecipe/{product_id}','RecipeController@listrecipe');
	Route::get('branch/product/showrecipematerial','RecipeController@showrecipematerial');
	Route::get('recipe/q1','RecipeController@recipeQ1');
	Route::get('getunit/{product_id}','RecipeController@getUnit');
	Route::post('saverawmaterial','RecipeController@saveRawMaterial');
	
	
	
?>