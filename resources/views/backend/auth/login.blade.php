@extends('backend.layout.auth-layout.master')
@section('content')
    <section class="gradient-form">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center" style="height:100vh">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black" style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="{{ asset('backend/assets/images/sepco-logo.png') }}" style="width: 100px;"
                                            alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">SEPCO Content Management System</h4>
                                    </div>
									
										@if(isset($errors) && $errors->any())
											<div class="alert alert-danger">
												<ul>
													@foreach ($errors->all() as $error)
														<li>{{ $error }}</li>
													@endforeach
												</ul>
											</div>
										@endif
                                    <form action="{{ route('manager.login.post') }}" method="POST">
                                        @csrf
                                        <div data-mdb-input-init class="input-container mb-2">
                                            <input placeholder="Enter Email" class="input-field" type="text"
                                                name="email" required>
                                            <span class="input-highlight"></span>
                                        </div>

                                        <div data-mdb-input-init class="input-container mb-2">
                                            <input placeholder="Enter Password" class="input-field" type="password"
                                                name="password" required>
                                            <span class="input-highlight"></span>
                                        </div>

                                        <div class="text-center pt-1 mb-5 mt-3 pb-1">
                                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-block"
                                                type="submit">Log in</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">SEPCO (Sukkur Electric Power Company)</h4>
                                    <p class="small mb-0">The distribution company SEPCO (Sukkur Electric Power Company) has been formed by bifurcating HESCO (modified) so that the areas of operation that were entirely under the jurisdiction of HESCO have now been divided between the two DISCOs. SEPCO is a newly created company via notification No. MDP / GM /HR /Dir/ (O&M) /PEPCO /1632-99 Dated: 26.07.2010 and started functioning with effect from 16.08.2010. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('specific_css')
        <style>
            .gradient-custom-2 {
                background: navy;
            }

            @media (min-width: 768px) {
                .gradient-form {
                    /* height: 100vh !important; */
                }
            }

            @media (min-width: 769px) {
                .gradient-custom-2 {
                    border-top-right-radius: .3rem;
                    border-bottom-right-radius: .3rem;
                }
            }

            /* From Uiverse.io by Satwinder04 */
            /* Input container */
            .input-container {
                position: relative;
            }

            /* Input field */
            .input-field {
                display: block;
                width: 100%;
                padding: 10px;
                font-size: 16px;
                border: none;
                border-bottom: 2px solid #ccc;
                outline: none;
                background-color: transparent;
            }


            /* Input highlight */
            .input-highlight {
                position: absolute;
                bottom: 0;
                left: 0;
                height: 2px;
                width: 0;
                background-color: black;
                transition: all 0.3s ease;
            }

            /* Input field:focus styles */
            .input-field:focus {
                top: -20px;
                /* font-size: 12px; */
                color: black;
            }

            .input-field:focus+.input-highlight {
                width: 100%;
            }
        </style>
    @endpush
    @push('specific_js')
    @endpush
@endsection
