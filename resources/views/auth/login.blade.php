@extends('layouts.master')
@section('title', 'Login - Web Pengelolaan Website Sekolah')
@section('content')
    <div class="mb-0 border-none shadow-none xl:w-2/3 card bg-white/70 dark:bg-zink-500/70">
        <div class="grid grid-cols-1 gap-0 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <div class="!px-12 !py-12 card-body">

                    <div class="text-center">
                        <h4 class="mb-2 text-purple-500 dark:text-purple-500">Welcome Back !</h4>
                        <p class="text-slate-500 dark:text-zink-200">Sign in to continue to Web Admin Pengelola Website
                            Sekolah.</p>
                    </div>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="mt-5 text-sm text-red-500">{{ $error }}</div>
                        @endforeach
                    @endif


                    <form action="{{ route('authenticate') }}" class="mt-7" method="post">
                        @csrf
                        <div class="hidden px-4 py-3 mb-3 text-sm text-green-500 border border-green-200 rounded-md bg-green-50 dark:bg-green-400/20 dark:border-green-500/50"
                            id="successAlert">
                            You have <b>successfully</b> signed in.
                        </div>
                        <div class="mb-3">
                            <label for="username" class="inline-block mb-2 text-base font-medium">Email</label>
                            <input type="text" id="username" name="email"
                                class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                placeholder="Enter email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="inline-block mb-2 text-base font-medium">Password</label>
                            <input type="password" id="password" name="password"
                                class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                placeholder="Enter password">
                        </div>
                        <div class="mt-10">
                            <button type="submit"
                                class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Sign
                                In</button>
                        </div>
                    </form>
                </div>
            </div>
            <div
                class="hidden mx-2 mt-2 mb-2 border-none shadow-none lg:col-span-7 lg:block card bg-white/60 dark:bg-zink-500/60">
                <div class="!px-10 !pt-10 h-full !pb-0 card-body flex flex-col">
                    <div class="flex items-center justify-between gap-3">
                        <div class="grow">
                            <a href="#">
                                <img src="{{ asset('assets/images/logosmk.png') }}" alt=""
                                    class="hidden h-14 dark:block">
                                <img src="{{ asset('assets/images/logosmk.png') }}" alt=""
                                    class="block h-14 dark:hidden">
                            </a>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <img src="assets/images/img-01.png" alt="" class="md:max-w-[24rem] mx-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
