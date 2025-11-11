@extends('layouts.app')
@section('title', $news->title)
@section('content')
<div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">

    <div class="container mx-auto p-6">
        <div class="max-w-4xl mx-auto bg-white rounded shadow-sm p-6">
            <h1 class="text-3xl font-bold mb-4">{{ $news->title }}</h1>

            <div class="mb-4 text-sm text-gray-600">
                <span>Kategori: {{ $news->category->name }}</span> |
                <span>Tanggal: {{ $news->created_at->format('d M Y') }}</span>
            </div>

            <div class="prose max-w-none">
                {!! $news->content !!}
            </div>

            <div class="mt-6 pt-4 border-t">
                <a href="{{ route('news.index') }}" style="background: gray; color white" class="inline-block px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Kembali ke Daftar Berita
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
