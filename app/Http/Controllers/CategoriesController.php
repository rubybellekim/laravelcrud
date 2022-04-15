<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    // bring every data of category from DB
    static function getAllCategories()
    {
        return DB::select("select * from categories;");
    }

    //create new category & update DB
    static function addCategory($name)
    {
        DB::table("categories")->insert(array('name' => $name));
    }

    //delete category & update DB
    static function removeCategory($id)
    {
        DB::table("categories")->where("id", $id)->delete();
    }

    //edit category info & update DB
    static function editCategory($id, $name)
    {
        DB::table("categories")->where("id", $id)->update(array('name' => $name));
    }

    //check if the category name field is not empty & already exist
    static function checkName($newName)
    {
        if (strlen($newName) === 0)
        {
            return view('category_edit', ["nameError" => "value is empty"]);
        }
        else
        {
            $existingCategory = DB::table("categories")->select("id")->where("name", $newName)->get();

            if (count($existingCategory) > 0)
            {
                return view('category_edit', ["name" => $newName,
                                              "nameError" => "category already exists"]);
            }
        }
    }

    static function checkExistingCategory($id, $newName)
    {
        if (strlen($newName) === 0)
        {
            return view('category_edit', ["id" => $id,
                                          "nameError" => "value is empty"]);
        }
        else
        {
            $existingCategory = DB::table("categories")->select("id")
                                                       ->where("name", $newName)
                                                       ->where("id", "!=", $id)->get();

            if (count($existingCategory) > 0)
            {
                return view('category_edit', ["id" => $id,
                                              "name" => $newName,
                                              "nameError" => "category already exists"]);
            }
        }
    }

    //request to add category & validation check
    public function requestAddCategory(Request $request)
    {
        $newCategoryName = $request->input('name');
        $validation = CategoriesController::checkName($newCategoryName);
        if ($validation)
        {
            return $validation;
        }
        
        CategoriesController::addCategory($newCategoryName);
        return redirect('categories');
    }

    //request to show category
    public function requestShowCategory(Request $request, $id)
    {
        $currentCategory = DB::table("categories")->select("name")->where("id", $id)->first();

        return view('category_edit', ["id" => $id, "name" => $currentCategory->name]);
    }
    //request to edit category & validation check
    public function requestEditCategory(Request $request, $id)
    {
        $newCategoryName = $request->input('name');

        $validation = CategoriesController::checkExistingCategory($id, $newCategoryName);
        if ($validation)
        {
            return $validation;
        }
        
        CategoriesController::editCategory($id, $newCategoryName);
        return redirect('categories');
    }

     //request to delete category
    public function requestDeleteCategory(Request $request, $id)
    {
        CategoriesController::removeCategory($id);
        return redirect('categories');
    }
}
