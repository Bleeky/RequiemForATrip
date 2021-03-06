<?php namespace Dokoiko\Http\Controllers;

use Dokoiko\Http\Requests\MailSendingRequest;
use Dokoiko\Picture;
use Dokoiko\Place;
use Dokoiko\Video;
use Illuminate\Support\Facades\Input;
use Response;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller {

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getHome()
	{
		return view('user.pictures.home')->with('pictures', Picture::where('status', '=', '1')->orderBy('date', 'desc')->take(8)->get());
	}

	public function getNumberOfPictures()
	{
		$total = Picture::where('status', '=', '1')->count();
		$recentPictureID = Picture::where('status', '=', '1')->orderBy('date', 'desc')->take(1)->get();
		$oldPictureID = Picture::where('status', '=', '1')->orderBy('date', 'asc')->take(1)->get();
		$response = array(
			'total'             => $total,
			'recent-picture-id' => $recentPictureID->first()->id,
			'old-picture-id'    => $oldPictureID->first()->id,
		);

		return Response::json($response);

	}

	public function getPicture($id)
	{
		return view('user.pictures.picture')->with('picture', Picture::find($id));
	}

	public function getSelectedPicture($id)
	{
		return view('user.pictures.selected')->with('picture', Picture::find($id));
	}

	public function getNextPicture($id)
	{
		$currentPicture = Picture::find($id);

		return view('user.pictures.selected')->with('picture', Picture::where('date', '<', $currentPicture->date)->where('status', '=', '1')->orderBy('date', 'desc')->first());
	}

	public function getPreviousPicture($id)
	{
		$currentPicture = Picture::find($id);

		return view('user.pictures.selected')->with('picture', Picture::where('date', '>', $currentPicture->date)->where('status', '=', '1')->orderBy('date', 'asc')->first());
	}

	public function getSetOfPictures($offset)
	{
		return view('user.pictures.setOfPictures')->with('pictures', Picture::where('status', '=', '1')->orderBy('date', 'desc')->skip($offset)->take(8)->get());
	}

	public function getPays()
	{
		return view('user.pays')->with('places', Place::all()->toJson());
	}

	public function getContact()
	{
		return view('user.contact');
	}

	public function postSendMail(MailSendingRequest $request)
	{
		$mail = $request->all();
		Mail::send('emails.contact', ['contact' => $mail], function($message)
		{
            $message->from('hausser-quentin@gmail.com', 'Dokoiko');
			$message->to('hausser-quentin@hotmail.com', 'Dokoiko')->subject('Contact');
		});
		return view('user.contact')->withErrors(['success' => 'Mail successfully sent !']);
	}

	public function getVideos()
	{
		return view('user.videos')->with('videos', Video::where('status', '=', '1')->orderBy('date', 'desc')->get());
	}

}
