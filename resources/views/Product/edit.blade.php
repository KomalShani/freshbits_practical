@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update Product') }} 
                    
                <div class="card-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                   <section class="content">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-body">
                                    <form role="form" id="signup-form" enctype="multipart/form-data" class="signup-form" autocomplete="off" method="post" action="{{ route('product.update',$product->id) }}">
                                    {!! Form::model($product, ['method' => 'PATCH','route' => ['product.update', $product->id]]) !!}
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Name</strong>
                                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Price</strong>
                                                    {!! Form::number('price', null, array('placeholder' => 'Price','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>UPC</strong>
                                                    {!! Form::text('upc', null, array('placeholder' => 'UPC','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Image:</strong>
                                                    {!! Form::file('new_image', null, array('class' => 'form-control','multiple')) !!}
                                                    <input type="hidden" name="image" id="image" value="<?php echo $product->image; ?>">
                                                </div>
                                                <div class="col-md-3 col-xs-12 common-class">
                                                    <div>
                                                        <?php
                                                        if (($product->image) || (file_exists(public_path() . '/images/' . $product->image))) {
                                                        ?>
                                                            <span class="closeImgBtn1 closeImgBtn">&times;</span>
                                                            <a data-toggle="lightbox" href="#uphotoLightbox">
                                                                <img src="{{ URL::to('/') }}/images/<?php echo $product->image; ?>" class="img-thumbnail" id="img1" />
                                                            </a>
                                                            <div id="uphotoLightbox" class="lightbox fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class='lightbox-dialog'>
                                                                    <div class='lightbox-content'>
                                                                        <img src="{{ URL::to('/') }}/images/<?php echo $product->image; ?>">
                                                                        <div class="lightbox-caption">
                                                                            <p>Image</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } else { ?>
                                                            {""}
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection




<