@extends('frontend.layouts.main')
  @section('content')
    {{-- {{dd(Session::all())}} --}}
    {{-- {{dd(Input::old('img-name'))}} --}}
    <div class="container-fluid page">
        <div class="content container">
            <div class="row fadeIn wow animated">
              {{ Form::open(array('url' => 'upload', 'class' => 'img-upload', 'enctype' => 'multipart/form-data')) }}
                <div class="col-md-3 form-block">
                  <div class="form-group ">
                    <label class="control-label" for="inputGroupSuccess1">Nom de l'image </label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-align-left"></i></span>
                      <input type="text" class="form-control" id="inputGroupSuccess1" name="img-name" aria-describedby="inputGroupSuccess1Status" value="{{Input::old('img-name')}}">
                    </div>
                    <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                  </div>

                  <div class="form-group ">
                    <label class="control-label" for="inputGroupSuccess1">Les mots clés de l'image </label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
                      <input id="search-keywors" data-role="tagsinput" data-container-class="img-keyword" name="search-keywors" type="text" placeholder="" class="form-control" value="{{Input::old('search-keywors')}}">
                    </div>
                    <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                  </div>
                </div>
                    <div class="col-md-6 col-md-offset-1 upload form-block">
                        <button type="button" disabled class="btn btn-success edit-img" ><i class="fa fa-pencil-square-o"></i> Modfier l'image...</button>
                        <div class="progress img-progress">
                          <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            0%
                          </div>
                        </div>
                        <div class="img-drop-zone uploaded-img">
                          <i class="fa fa-plus"></i>
                          <input class="img-btn-upload" id="upload-img-btn" accept="image/*" type="file"  name="Filedata" value="" placeholder="">
                        </div>
                        <div class="alert alert-danger up-error"><!--
                      -->@if($errors->all())
                              @foreach ($errors->all() as $error)
                                  <p>{{ $error}}</p>
                              @endforeach
                          @endif<!--
                    --></div>
                        <div class="text-center">
                          <small class="img-name"></small>
                        </div>
                        <p class="lead text-center">OU</p>
                        <!-- <img id='image1' src='http://images.aviary.com/imagesv5/feather_default.jpg'/> -->
                        <div class="form-group ">
                          <label class="control-label" for="url-img-load">Chargez une image depuis un URL </label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
                            <input type="text" class="form-control url-img-load" id="url-img-load" aria-describedby="url-img-load-Status" placeholder="EXEMPLE: www.site.com/un/lien/vers/une/image.jpg" name="img-url">
                          </div>
                          <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <button type="button" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-refresh"></i> Charger l'image</button>
                        <button disabled type="submit" class="btn btn-block btn-primary btn-upload"><span class="glyphicon glyphicon-ok"></span> Ajouter</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div><!-- /.container -->
  @stop