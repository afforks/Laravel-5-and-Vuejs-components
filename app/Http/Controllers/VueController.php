<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests;
use App\Item;
use App\State;
use App\Lern;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VueController extends Controller
{
    
    public function index()
    {    
        return view('vue.index');
    }

    public function dependency()
    {
        $countries = Country::all();
        $states = State::all();
    	$cities = City::all();
    	return view('vue.dependency',compact('countries','states','cities'));
    }
    public function addmore()
    {
    	
    	return view('vue.addmore');
    }

    public function getItem()
    {
        return view('vue.items');
    }

    public function saveItem(Request $request)
    {
        $this->validate($request,['name'=>'required','price'=>'required|numeric|min:1','no_of_items'=>'required|numeric|min:1','discount'=>'numeric']);
        $item = Item::create($request->all());
        if(\Request::ajax())
        {
            return ['message'=>'Item Added Successfully!','item'=>$item];
        }
        
    }

    public function test()
    {
        return view('vue.test');
    }

    public function allItems(Request $request)
    {
        $column = $request->get('column');
        $sort = $request->get('sort');
        $value = $request->get('value');
        $op = $request->get('op');
        $model = app(Item::class);
        if(($column && $sort) ||($column && $value))
        {
            if($sort)
                $model = $model->orderBy($column,$sort);
            if($value)
            {
                if($op == "like")
                    $model = $model->where($column,'LIKE','%'.$value.'%');
                else
                    $model = $model->where($column,$value);
            }
        }
        else
        {
            $model = $model->latest();
        }
        $paginator = $model->paginate(10);
        return $paginator;
    }
    public function deleteItem($id)
    {
        $item=Item::find($id);
        $item->deleted = '1';
        $item->save();
        if(\Request::ajax())
        {
            return ['message'=>'Item Deleted Successfully','item'=>$item];
        }
    }
    public function updateItem($id,Request $request)
    {
        $this->validate($request,['name'=>'required','price'=>'required|numeric|min:1','no_of_items'=>'required|numeric|min:1','discount'=>'numeric']);
        $input = $request->all();
        $item = Item::find($id);
        $item->update($input);
        if(\Request::ajax())
        {
            return ['message'=>'Record Updated Successfully','item'=>$item];
        }
    }

    public function multiSelect()
    {
        $cities = City::lists('name','id');
        return view('vue.multiselect',compact('cities'));
    }

    public function select2()
    {
        $cities = City::lists('name','id');
        $states =  State::all();
        $states->map(function($state,$key){
            $state->text = $state->name;
        });
        return view('vue.select2',compact('cities','states'));
    }

    public function excel()
    {
        return view('vue.excel');
    }

    public function csv()
    {
        return view('vue.csv');
    }

    public function lern()
    {
        throw new \Exception("Error Processing Request", 1);
    }

    public function tabs()
    {
        return view('vue.tabs');
    }

    public function getCountries()
    {
        return Country::all();
    }

    public function getStates()
    {
        return State::all();
    }

    public function getCities()
    {
        return City::all();
    }

    public function getItems(Request $request)
    {
        $sort = $request->get('sort');
        $perPage = $request->get('per_page');
        $filter = $request->get('filter');
        $filters = $request->get('filters');

        $model=app(Item::class);
        if($sort){
            $arr = explode('|', $sort);
            $column = $arr[0];
            $type = $arr[1];
            $model = $model->orderBy($column,$type);
        }
        if($filter)
        {
            $model->where('name','LIKE','%'.$filter.'%')
                ->orWhere('price','LIKE','%'.$filter.'%')
                ->orWhere('no_of_items','LIKE','%'.$filter.'%')
                ->orWhere('discount','LIKE','%'.$filter.'%')
                ->orWhere('total','LIKE','%'.$filter.'%');
        }
        else
        {
            if (!empty($filters) && is_array($filters)) {
                foreach ($filters as $column => $row) {
                    if (!empty($column) && !empty($row['value']) && is_array($row)) {
                        $operator = $row['type'];
                        if ($operator == "like") {
                            $model->where($column, $operator, "%" . $row['value'] . "%");
                        } else {
                            $model->where($column, $operator,  $row['value']);
                        }
                    }
                }
            }
        }

        $paginator = $model->paginate($perPage?$perPage:10);
        return $paginator;
    }

    public function images()
    {
        return view('vue.image');
    }
    public function postImages(Request $request)
    {
        $files = $request->file('image');
        $name = "file_".Carbon::now()->format('Y-m-d-h-i-s').".".$files->getClientOriginalExtension();
        $files->move('upload',$name);
        return $name;
    }

    public function postMultiImages(Request $request)
    {
        $files = $request->file('images');
        $output=[];
        foreach ($files as $key => $file) {
            $name = "file_".uniqid().Carbon::now()->format('Y-m-d-h-i-s').".".$file->getClientOriginalExtension();
            $file->move('upload',$name);
            array_push($output,$name);
        }
        return $output;
    }



    public function vueTable()
    {
        return view('vue.vue-table.index');
    }

    public function saveCsv(Request $request)
    {
        $data = $request->get('data');
        $input=[];
        foreach ($data as $key => $row) {
            array_push($input,$row);
        }
        if($input)
        {
            Item::insert($input);
        }
        return ['message'=>'Record added Successfully..'];
    }


    public function errorPage()
    {
        $exceptions =  Lern::with('user')->latest()->paginate(10);
        return view('vue.error-index',compact('exceptions'));
    }

    public function getExceptions()
    {
        return Lern::with('user')->latest()->paginate(10);
    }

    public function fetchItem($id)
    {
        return Item::find($id);
    }

    public function keyEvents()
    {
        return view('vue.key-events');
    }
}
