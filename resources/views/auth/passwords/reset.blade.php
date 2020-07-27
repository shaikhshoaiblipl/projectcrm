@extends('auth.valex_app')
@section('content')
<div class="container-fluid">
      <div class="row no-gutter">
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
          <div class="row wd-100p mx-auto text-center">
            <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
              @php $logo = getSetting('logo'); @endphp
              @if(isset($logo) && $logo!=''  && \Storage::exists(config('constants.SETTING_IMAGE_URL').$logo))
              <img src="{{ \Storage::url(config('constants.SETTING_IMAGE_URL').$logo) }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
              @endif
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
          <div class="login d-flex align-items-center py-2">
            <div class="container p-0">
              <div class="row">
                <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                  <div class="card-sigin">
                    <div class="mb-5 d-flex"> 
                      @php $logo = getSetting('logo'); @endphp
                      @if(isset($logo) && $logo!=''  && \Storage::exists(config('constants.SETTING_IMAGE_URL').$logo))
                      <a href="javascript:void(0)">
                      <img src="{{ \Storage::url(config('constants.SETTING_IMAGE_URL').$logo) }}" class="sign-favicon ht-40" alt="logo">
                      @endif

                     </a></div>
                    <!--  <a href="index.html"><img src="{{ asset('template/valex-theme/img/brand/favicon.png') }}" class="sign-favicon ht-40" alt="logo"></a> -->
                    <div class="card-sigin">
                      <div class="main-signup-header">
                        <h2>{{ __('Reset Password') }}?</h2>
                        @if($flash = session('error'))            
                          <div class="alert alert-danger alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                               {{ $flash }}
                          </div>
                        @endif
                        @if($flash = session('success'))      
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                 {{ $flash }}
                            </div>
                        @endif
                        <form class="user" method="POST" action="{{ route('password.update') }}">
                                @csrf
                          <input type="hidden" name="token" value="{{ $token }}">
                          <div class="form-group">
                            <label>Email</label> 
                             <input id="email" type="email" class="form-control  form-control-user @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus  placeholder="Enter {{ __('E-Mail Address') }}...">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                          <div class="form-group">
                            <input id="password" type="password" class="form-control  form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="password" autofocus  placeholder="Enter {{ __('Password') }}...">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                           <div class="form-group">
                            <input id="password-confirm" type="password" class="form-control  form-control-user @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="password" autofocus  placeholder="Enter {{ __('Confirm Password') }}...">
                                  @error('password_confirmation')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                          </div>
                          <button class="btn btn-main-primary btn-block">{{ __('Reset Password') }}</button>
                        </form>
                        <div class="main-signin-footer mt-5">
                          @if (Route::has('password.request'))
                          <p><a href="{{ route('login')}}">Already have an account? Login!</a></p>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
