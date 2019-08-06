<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Video;
use App\Comment;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('video.createVideo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validar formulario
        $validatedData = $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required',
            'video' => 'mimes:mp4'
        ]);

        $video =new Video();
        $user = \Auth::user();
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //Subida de imagen miniatura
        $image = $request->file('image');
        if ($image) {
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path;
        }

        //Subida del video
        $video_file = $request->file('video');
        if ($video_file) {
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));

            $video->video_path = $video_path;

        }

        $video->save();

        return redirect()->route('home')->with(array('message' => 'El video se ha subido correctamente'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($video_id)
    {
        $video = Video::find($video_id);

        return view('video.detail', array(
            'video' => $video
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($video_id)
    {
        $user =\Auth::user();
        $video = Video::findOrFail($video_id);

        if ($user && $video->user_id == $user->id) {
            return view('video.edit', array(
                'video' => $video
            ));
        } else {
            return view('home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $video_id)
    {
        //Validar formulario
         $validatedData = $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required',
            'video' => 'mimes:mp4',
            'image' => 'mimes:jpeg,png,gif'
        ]);

        $user =\Auth::user();
        $video = Video::findOrFail($video_id);

        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //Subida de imagen miniatura
        $image = $request->file('image');
        if ($image) {
            //Eliminar imagen anterior            
            Storage::disk('images')->delete($video->image);

            //Guardar nueva imagen
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path;
        }

        //Subida del video
        $video_file = $request->file('video');
        if ($video_file) {
            //Eliminar video anterior
            Storage::disk('videos')->delete($video->video_path);

            //Guardar nueva video
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));

            $video->video_path = $video_path;

        }

        $video->update();

        return redirect()->route('home')->with(array('message' => 'El video se ha actualizado correctamente'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($video_id)
    {
        $user =\Auth::user();
        $video = Video::find($video_id);
        $comments = Comment::where('video_id', $video_id)->get();

        if ($user && $video->user_id == $user->id) {

            //Eliminar comentarios
            if ($comments && count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comments->delete();                
                }
            }

            //Eliminar ficheros
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);

            //Eliminar registro
            $video->delete();

            //Mensaje a devolver
            $message = array('message' => 'El video se eliminó correctamente!!');
        } else {
            $message = array('message' => 'ERROR, el video no pudo eliminarse');
        }

        return redirect()->route('home')->with($message);
    }

    public function getImage($filename) {
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }    

    public function getVideo($filename) {
        $file = Storage::disk('videos')->get($filename);
        return new Response($file, 200);
    }

    public function search($search = null, $filter = null) {

        if (is_null($search)) {
            $search = \Request::get('search');

            if (is_null($search)) {
                return redirect()->route('home');
            }

        }

        if (is_null($filter) && \Request::get('filter') && !is_null($search)) {
            $filter = \Request::get('filter');

            return redirect()->route('searchVideo', array('search' => $search, 'filter' => $filter));

        }

        $column = 'id';
        $order = 'desc';

        if (!is_null($filter)) {
            if ($filter == 'new') {
                $column = 'id';
                $order = 'desc';
            }

            if ($filter == 'old') {
                $column = 'id';
                $order = 'asc';
            }

            if ($filter == 'alfa') {
                $column = 'title';
                $order = 'asc';
            }
        } 

        $videos = Video::where('title', 'LIKE', '%' . $search . '%')->orderBy($column, $order)->paginate(5);

        return view('video.search', array(
            'videos' => $videos,
            'search' => $search
        ));
    }
}
