<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookphone;
use App\Data;
use App\User;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
use Excel;
use Illuminate\Support\Facades\Auth;
use DateTime;

class BookphoneController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
	 
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

	public function downloadExcel()
	{
		if(isset($_GET['bp_id']))
		{
			$data = Bookphone::whereIn('id', $_GET['bp_id'])->get()->toArray();
			return Excel::create('example', function($excel) use ($data) {
				$excel->sheet('mySheet', function($sheet) use ($data)
				{
					$sheet->fromArray($data);
				});
			})->download($_GET['type']);
		}else{
			return view('bookphones', [
				'msg' => 'выбирите экспортируемые данные =)',
			]);
		}
	}
	
	/* Выбрать записи избранного пользователем */
	public function favItems(Request $request)
    {
		//$bp = Bookphone::orderBy('created_at', 'asc')->get();

		$bp = Data::where(['user_id' => \Auth::user()->id])->first();
		if($bp){
			$arr =  explode(",", $bp->bookphone_id);
			$bp = Bookphone::whereIn('id', $arr)->get();
		}
		return view('favourites', [
			'data' => $bp
		]);
	}
	
	/* Добавить запись в избранное пользователя */
    public function addFav(Request $request)
    {
        $rules = array(
                //'id' => 'alpha_num',
        );
		
        $validator = Validator::make(Input::all(), $rules);
		
        if ($validator->fails()) {
            return Response::json(array(
                    'errors' => $validator->getMessageBag()->toArray(),
            ));
        } else {
			$user_id =  \Auth::user()->id;
			$data = Data::where(['user_id' => $user_id])->first(); 

			if($data){
					
				if($request->name=='add'){
					$data->bookphone_id = $data->bookphone_id.','.$request->id;
				}else{
					$arr = explode(",", $data->bookphone_id);
						
					if(!isset($arr[1])){
						Data::where(['user_id' => $user_id])->delete();
					}else{
						$key = array_search($request->id,$arr);
						unset($arr[$key]);
						$data->bookphone_id = implode(",", $arr);
					}
				}
					
			}else{
				$data = new Data();
				$data->user_id = $user_id;
				$data->bookphone_id = $request->id;
			}

            $data->save();
            return response()->json($data);
        }
    }
	
	/* Список телефонной книги */
    public function readItems(Request $req)
    {
		$bp = Data::where(['user_id' => \Auth::user()->id])->first();
		if($bp){
			$bp = explode(",", $bp->bookphone_id);
		}

		if(isset($_GET['search'])){
			$search = $_GET['search'];
			$data = Bookphone::where("name", "LIKE", "%$search%")
			->orWhere("phone", "LIKE", "%$search%")
			->orWhere("name", "LIKE", "%$search%")
			->orWhere("street", "LIKE", "%$search%")
			->orWhere("home", "LIKE", "%$search%")
			->get();
		}else{
			$data = Bookphone::all();
		}

		if(Auth::user()->isAdmin() == true){
			return view('admin', compact('data', 'bp'));
		}else{
			return view('bookphones', compact('data', 'bp'));
		}
    }

	/* Добавить запись в телефонную книгу */
    public function addItem(Request $request)
    {
        $rules = array(
                'name' => 'required|alpha_num',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(array(

                    'errors' => $validator->getMessageBag()->toArray(),
            ));
        } else {
			
			$time = new DateTime();
            $data = new Bookphone();
            $data->phone = $request->phone;
			$data->name = $request->name;
			$data->street = $request->street;
			$data->home = $request->home;
			$data->created_at = $time;
			$data->updated_at = $time;
            $data->save();
			
            return response()->json($data);
        }
    }
	
	/* Редактировать запись телефонной книги */
    public function editItem(Request $req)
    {
        $data = Bookphone::find($req->id);
        $data->phone = $req->phone;
		$data->name = $req->name;
		$data->street = $req->street;
		$data->home = $req->home;
        $data->save();

        return response()->json($data);
    }
	
	/* Удалить запись телефонной книги */
    public function deleteItem(Request $req)
    {
        Bookphone::find($req->id)->delete();

        return response()->json();
    }







    /** REST\SOAP
     * Display a listing of the resource.
     *
     * @return Response
     * curl --user admin:admin localhost/api/pages
     */

    public function index($type) {
        $bp = Bookphone::all();
		if($type == 'xml'){
			
			$obj = "<?xml version='1.0' encoding='UTF-8'?>";
			$obj .= "<book>";
			foreach($bp as $xml){
				$obj .= "<Order>";
				$obj .= "<id>{$xml->id}</id>";
				$obj .= "<phone>{$xml->phone}</phone>";
				$obj .= "<name>{$xml->name}</name>";
				$obj .= "<street>{$xml->street}</street>";
				$obj .= "<home>{$xml->home}</home>";
				$obj .= "</Order>";
			}
			$obj = "</book>";
			return $obj;
			
		}else{
			return Response::json(array(
				'status' => 'success',
				'bookphones' => $bp->toArray()),
				200
			);
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     * curl --user admin:admin -d 'title=sample&slug=abc' localhost/api/pages
     */

    public function store() {
		
        // add some validation also
        $input = Input::all();

        $bp = new Bookphone;

        if ( $input['title'] ) {
            $bp->title =$input['title'];
        }
        if ( $input['slug'] ) {
            $bp->slug =$input['slug'];
        }

        $bp->save();

        return Response::json(array(
            'error' => false,
            'bookphones' => $bp->toArray()),
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     * curl --user admin:admin localhost/api/pages/2
     */

    public function show($type,$id) {
		
        $bp = Bookphone::where('id', $id)
                    ->take(1)
                    ->get();

			if($type == 'xml'){
				
				$obj = "<?xml version='1.0' encoding='UTF-8'?>";
				$obj .= "<book>";
				foreach($bp as $xml){
					$obj .= "<Order>";
					$obj .= "<id>{$xml->id}</id>";
					$obj .= "<phone>{$xml->phone}</phone>";
					$obj .= "<name>{$xml->name}</name>";
					$obj .= "<street>{$xml->street}</street>";
					$obj .= "<home>{$xml->home}</home>";
					$obj .= "</Order>";
				}
				$obj .= "</book>";
				return $obj;
			}else{
				return Response::json(array(
					'status' => 'success',
					'bookphones' => $bp->toArray()),
					200
				);
			}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     * curl -i -X PUT --user admin:admin -d 'title=Updated Title' localhost/api/pages/2
     */

    public function update($id) {

        $input = Input::all();

        $bp = Bookphone::find($id);

        if ( $input['title'] ) {
            $bp->title =$input['title'];
        }
        if ( $input['slug'] ) {
            $bp->slug =$input['slug'];
        }

        $bp->save();

        return Response::json(array(
            'error' => false,
            'message' => 'Bookphone Updated'),
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     * curl -i -X DELETE --user admin:admin localhost/api/pages/1
     */

    public function destroy($id) {
        $bp = Bookphone::find($id);

        $bp->delete();

        return Response::json(array(
            'error' => false,
            'message' => 'Bookphone Deleted'),
            200
        );
    }

}
