@extends('layouts.client')
@section('content')

    <div class="about">

        <section class="row flex items-center">

            <div class="box">
                <div class="mb-5 text-center">
                    <h1 style="color:#007bff; margin-bottom:3rem; margin-top:1rem;"><strong>ABOUT US</strong></h1>
                </div>
                <!-- Start about us Area -->
                <section class="cown-down mt-4" style="position: relative; overflow:hidden;">
                    <div class="section-inner">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 col-12 padding-left" style="padding-right:0;">
                                    <div class="image">
                                        <img src="{{asset('images/dairy.jpg')}}" alt="#" style="width:100%; height:100%;">
                                    </div>	
                                </div>	
                                <div class="col-lg-6 col-12 padding-right" style="padding-left:0;">
                                    <div class="content bg-light" style="text-align: center; height: 100%; position:relative;">
                                        <div class="heading-block" style="position:absolute; left:0; top:52%; transform:translateY(-50%); padding: 55px;">
                                            <h3 class="title" style="margin-bottom: 1rem;">General Trias Dairy Raisers Multi-Purpose Cooperative + Gentri's Best</h3>
                                            <p class="text" style="font-size:11px; color:#666; text-align: justify;">
                                                The Dairy Processing Center is the first of its kind in the Province of Cavite and, most likely, the
                                                entire CALABARZON Region, and was made possible by the collaboration of the General Trias Local
                                                Government, the General Trias Dairy Raisers Multi-Purpose Cooperative (GTDRMPC), the Korea
                                                International Cooperation Agency (KOICA), and the Philippine Carabao Center (PCC) of the
                                                Department of Agriculture. This multi-million project is outfitted with cutting-edge
                                                medium-scale machinery capable of processing 500 liters of raw milk every batch, which can meet
                                                the town's expanding carabao milk output and collection.
                                            </p>
                                            <p class="text" style="font-size:11px; color:#666; text-align: justify;">                                                The
                                                General Trias Dairy Raisers Multi-Purpose Cooperative (GTDRMPC) is at the core of Gentri's Best.
                                                It was created and registered on August 10, 2005, primarily to promote dairying and dairy
                                                entrepreneurship in order to enhance the quality of life of Carabao raisers.</p>
                                            <p class="text" style="font-size:11px; color:#666; text-align: justify;">
                                                GTDRMPC began operations in 2005 in a kitchen-style processing center with one donated freezer and
                                                self-acquired culinary supplies. It is administered and run by coop members who frequently
                                                participate in capacity-building programs organized by its partner organizations such as the PCC
                                                at UPLB, the Municipal Agriculture Office, and the DTI-Cavite. It currently produces 21 dairy
                                                products and taste variants, including fresh milk, flavored milk, white cheese, pastillas,
                                                yoghurt, milk-o-gel, ice candy, and yema, up from seven (7) previously.
                                            </p>
                                        </div>
                                    </div>	
                                </div>	
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /End about us Area -->

                <!-- Start vision Area -->
                <section class="cown-down" style="position: relative; overflow:hidden;">
                    <div class="section-inner">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 col-12 padding-left" style="padding-right:0;">
                                    <div class="content bg-light" style="text-align: center; height: 100%; position:relative;">
                                        <div class="heading-block" style="position:absolute; left:0; top:52%; transform:translateY(-50%); padding: 55px;">
                                            <h3 class="title" style="margin-bottom: 1rem;">Our Vision</h3>
                                            <p class="text" style="font-size:12px; color:#666; text-align: justify;">
                                                Isang maunlad, malakas, at nagkakaisang kooperatiba na tutulong upang mapaunlad ang kalagayang
                                                pangkabuhayan ng mga kasapi at ng buong komunidad sa pangkalakalan. 
                                            </p>
                                        </div>
                                    </div>	
                                </div>	
                                <div class="col-lg-6 col-12 padding-left" style="padding-left:0;">
                                    <div class="image">
                                        <img src="{{asset('images/vision.jpg')}}" alt="#" style="width:100%; height:100%;">
                                    </div>	
                                </div>	

                            </div>
                        </div>
                    </div>
                </section>
                <!-- /End Vision Area -->

                <!-- Start Mission Area -->
                <section class="cown-down" style="position: relative; overflow:hidden; margin-bottom:3rem;">
                    <div class="section-inner">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 col-12 padding-left" style="padding-right:0;">
                                    <div class="image">
                                        <img src="{{asset('images/mission.png')}}" alt="#" style="width:100%; height:100%;">
                                    </div>	
                                </div>	
                                <div class="col-lg-6 col-12 padding-right" style="padding-left:0;">
                                    <div class="content bg-light" style="text-align: center; height: 100%; position:relative;">
                                        <div class="heading-block" style="position:absolute; left:0; top:52%; transform:translateY(-50%); padding: 55px;">
                                            <h3 class="title" style="margin-bottom: 1rem;">Our Mission</h3>
                                            <p class="text" style="font-size:12px; color:#666; text-align: justify;">
                                                Ang pinaninindigang kontribusyon ng General Trias Dairy Raisers Multi-Purpose Cooperative upang
                                                makamit ang pananaw na ito ay ang patuloy na pagpapalakas ng kasapian, pagpapaunlad ng kanilang
                                                kaalaman at kasanayan, pagsuporta sa pagtaas ng kita ng mga kasapi at pagbibigay ng serbisyo sa
                                                anyo ng puhunan, pagbebenta ng mga produkto, at pagproseso ng kanilang produkto.
                                            </p>
                                        </div>
                                    </div>	
                                </div>	
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /End Mission Area -->
            </div>

        </section>
    </div>

@endsection
