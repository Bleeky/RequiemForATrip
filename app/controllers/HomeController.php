<?php

class HomeController extends BaseController 
{
	public function getIndex() {
		return View::make('Home.home')->with('pictures', Picture::where('status', '=', '1')->orderBy('date', 'desc')->take(8)->get());
	}
	public function getContact() {
		return View::make('Home.contact');
	}
	public function getPays() {
		return View::make('Home.pays');
	}
	public function getVideos() {
		//Faire un background : Soon
	}
	public function postSendMail() {
		Mail::send('Home.mail', array('message'=>Input::get('message')), function($message) {
			$message->to('hausser.quentin@gmail.com')->subject('Contact');
		});
	}
	public function getLastAndFirst() {
		if (Request::ajax()) {
			$last = Picture::where('status', '=', '1')->orderBy('date', 'desc')->take(1)->get();
			$first = Picture::where('status', '=', '1')->orderBy('date', 'asc')->take(1)->get();
			$response = array(
				'last'     => $last->first()->id,
				'first'		=> $first->first()->id,
				);
			return Response::json($response);
		}
	}
	public function getPictureTotal() {
		if (Request::ajax()) {
			$total = Picture::where('status', '=', '1')->count();
			$response = array(
				'total'     => $total,
				);
			return Response::json($response);
		}
	}
	public function getSelectedPicture($id) {
		return View::make('Home.Picture.selected')->with('picture', Picture::find($id));
	}
	public function getSetOfPictures($offset) {
		return View::make('Home.Picture.setOfPictures')->with('pictures', Picture::where('status', '=', '1')->orderBy('date', 'desc')->skip($offset)->take(8)->get());
	}
	public function getNextPicture($id) {
		$currentPicture = Picture::find($id);
		return View::make('Home.Picture.newPicture')->with('picture', DB::table('pictures')->where('date', '<', $currentPicture->date)->where('status', '=', '1')->orderBy('date', 'desc')->first());
	}
	public function getPreviousPicture($id) {
		$currentPicture = Picture::find($id);
		return View::make('Home.Picture.newPicture')->with('picture', DB::table('pictures')->where('date', '>', $currentPicture->date)->where('status', '=', '1')->orderBy('date', 'asc')->first());		
	}
}