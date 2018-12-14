<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;

class FavoritoController extends Controller
{
    private $token;

    public function __construct() 
    {
        $this->token = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favoritos = \App\Favorito::all()->where('cd_usuario', $this->token['cd_usuario']);

        if(!$favoritos){
            return response(["response"=>"Favoritos não encontrada"],400);
        }
        return response([$favoritos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request['bo_ativo'] = true;
        $request['cd_usuario'] = $this->token['cd_usuario'];

        $favorito = \App\Favorito::create($request->all());
        if(!$favorito){
            return  response(["response"=>"Erro ao salvar favorito"],400); 
        }
        return response(["response"=>"Salvo com sucesso",'ar'=>$favorito]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $favorito =  \App\Favorito::find($id);
        if($favorito['cd_usuario'] != $this->token['cd_usuario']){
            return response(['error'=>"Não tem permissão para deletar esse CategoriaDespesa"],400);
        }
        return response([$favorito]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $favorito =  \App\Favorito::find($id);
        if(!$favorito){
            return response(['response'=>'Favorito Não encontrado'],400);
        }
        if($favorito['cd_usuario'] != $this->token['cd_usuario']){
            return response(['error'=>"Não tem permissão para deletar esse CategoriaDespesa"],400);
        }
        $favorito->no_link =  $request['no_link'];
        $favorito->link =  $request['link'];
        $favorito->cd_categoria =  $request['cd_categoria'];
        $favorito->vl_link =  $request['vl_link'];

        if(!$favorito->update()){
            return response(['response'=>'Erro ao alterar'],400);
        }
        return response(['response'=>'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favorito =  \App\Favorito::find($id);
        if(!$favorito){
            return response(['response'=>'Favorito Não encontrado'],400);
        }
        if($favorito['cd_usuario'] != $this->token['cd_usuario']){
            return response(['error'=>"Não tem permissão para deletar esse CategoriaDespesa"],400);
        }
        $favorito->bo_ativo = false;
        if(!$favorito->save()){
            return response(["response"=>"Erro ao deletar conta"],400);
        }
        return response(['response'=>'Deletado com sucesso']);
    }
}
