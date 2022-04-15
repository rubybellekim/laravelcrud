<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoriesController;

class ItemsController extends Controller
{   // bring every data of items from DB
    static function getAllItems()
    {
        return DB::select("SELECT items.*, categories.name as category FROM items, categories " .
                          "WHERE items.id_category=categories.id;");
    }

    // check if any of the fields are empty & show error message
    static function checkEmpty($newItemTitle, $newItemCategory, $newItemDescription,
                               $newItemPrice, $newItemQuantity, $newItemSku)
    {
        $pageData = [];

        if (strlen($newItemTitle) === 0)
        {
            $pageData["errorTitle"] = "Title is empty";
        }
        if (strlen($newItemCategory) === 0)
        {
            $pageData["errorCategory"] = "Category should be selected";
        }
        if (strlen($newItemDescription) === 0)
        {
            $pageData["errorDescription"] = "Description is empty";
        }
        if (strlen($newItemPrice) === 0)
        {
            $pageData["errorPrice"] = "Price is empty";
        }
        if (strlen($newItemQuantity) === 0)
        {
            $pageData["errorQuantity"] = "Quantity is empty";
        }
        if (strlen($newItemSku) === 0)
        {
            $pageData["errorSku"] = "SKU is empty";
        }

        // if none of the fields are empty, send the changed data
        if (sizeof($pageData) > 0)
        {
            $pageData["title"] = $newItemTitle;
            $pageData["category"] = $newItemCategory;
            $pageData["description"] = $newItemDescription;
            $pageData["price"] = $newItemPrice;
            $pageData["quantity"] = $newItemQuantity;
            $pageData["sku"] = $newItemSku;
            $pageData["categories"] = CategoriesController::getAllCategories();
            return view('items_edit', $pageData);
        }
    }

    // ItemsController::checkEmpty($newItemTitle, $newItemDescription, 
    //                                                  $newItemPrice, $newItemQuantity,
    //                                                  $newItemSku, $newItemPicture);

    // add items and update DB
    static function addItems($title, $categoryID, $description, $price, $quantity, $sku, $picture)
    {
        DB::table("items")->insert(array('title' => $title,
                                         'id_category' => $categoryID,
                                         'description' => $description,
                                         'price' => $price,
                                         'quantity' => $quantity,
                                         'SKU' => $sku,
                                         'picture' => $picture
        ));
    }

    // edit items and update DB
    static function editItems($originalSKU, $title, $categoryID, $description, $price, $quantity, $sku, $picture)
    {
        $updateData = array('title' => $title,
                            'id_category' => $categoryID,
                            'description' => $description,
                            'price' => $price,
                            'quantity' => $quantity,
                            'SKU' => $sku);

        if (strlen($picture) > 0)
        {
            $updateData['picture'] = $picture;
        }

        DB::table("items")->where("SKU", $originalSKU)->update($updateData);
    }

    // delete items & update DB
    static function removeItems($sku)
    {
        DB::table("items")->where("SKU", $sku)->delete();
    }

    // upload image and receive the file name
    static function uploadPicture($request)
    {
        $pictureName = "";

        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/', $filename);

            $pictureName = $filename;
        }

        return $pictureName;
    }

    public function requestCreateItemView()
    {
        return view('items_edit', ["categories" => CategoriesController::getAllCategories()]);
    }

    //request to add items & validation check
    public function requestAddItems(Request $request)
    {
        $pageData = [];
        $newItemTitle = $request->input('title');
        $newItemCategory = $request->input('category');
        $newItemDescription = $request->input('description');
        $newItemPrice = $request->input('price');
        $newItemQuantity = $request->input('quantity');
        $newItemSku = $request->input('sku');
        $newItemPicture = "";

        if (sizeof($pageData) > 0)
        {
            $pageData['title'] = $newItemTitle;
            $pageData['category'] = $newItemCategory;
            $pageData['description'] = $newItemDescription;
            $pageData['price'] = $newItemPrice;
            $pageData['quantity'] = $newItemQuantity;
            $pageData['sku'] = $newItemSku;
            $pageData['items'] = ItemsController::getAllItems();
            return view('items_edit', $pageData);
        }

        $validation = ItemsController::checkEmpty($newItemTitle, $newItemCategory, $newItemDescription,
                                                  $newItemPrice, $newItemQuantity, $newItemSku);

        if ($validation)
        {
            return $validation;
        }

        //upload picture
        $newItemPicture = ItemsController::uploadPicture($request);

        ItemsController::addItems($newItemTitle, $newItemCategory, $newItemDescription, $newItemPrice, $newItemQuantity, $newItemSku, $newItemPicture);

        return redirect('items');
    }

    //request to show items
    public function requestShowItem(Request $request, $id)
    {
        $currentItems = DB::table("items")->select("*")->where("SKU", $id)->first();

        return view('items_edit', [ "title" => $currentItems->title,
                                    "description" => $currentItems->description,
                                    "price" => $currentItems->price,
                                    "quantity" => $currentItems->quantity,
                                    "sku" => $currentItems->SKU,
                                    "picture" => $currentItems->picture,
                                    "category" => $currentItems->id_category,

                                    "categories" => CategoriesController::getAllCategories()]);
    }

    //request to edit category & validation check
    public function requestEditItems(Request $request, $id)
    {
        $newItemTitle = $request->input('title');
        $newItemCategory = $request->input('category');
        $newItemDescription = $request->input('description');
        $newItemPrice = $request->input('price');
        $newItemQuantity = $request->input('quantity');
        $newItemSku = $request->input('sku');
        $newItemPicture = "";

        $validation = ItemsController::checkEmpty($newItemTitle, $newItemCategory, $newItemDescription,
                                                  $newItemPrice, $newItemQuantity, $newItemSku);

        if ($validation)
        {
            return $validation;
        }

        if ($request->hasFile('picture'))
        {
            $newItemPicture = ItemsController::uploadPicture($request);
        }

        ItemsController::editItems($id,
                                   $newItemTitle,
                                   $newItemCategory,
                                   $newItemDescription, 
                                   $newItemPrice, 
                                   $newItemQuantity, 
                                   $newItemSku, 
                                   $newItemPicture);
        return redirect('items');

    }

    //request to delete items
    public function requestDeleteItems(Request $request, $sku)
    {
        ItemsController::removeItems($sku);
        return redirect('items');
    }
}


