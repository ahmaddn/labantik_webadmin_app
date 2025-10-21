@extends('layouts.app')

@section('content')
<div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">


    <div class="container mx-auto p-6">
        <div class="max-w-4xl mx-auto bg-white rounded shadow-sm p-6">
            <h2 class="text-2xl font-semibold mb-6">Tulis Artikel</h2>
<form action="{{ route('news.store') }}" method="POST">
            @csrf
            <form class="grid grid-cols-12 gap-6">
                <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select class="block w-full rounded border-gray-200 shadow-sm p-3">
                        <option>Pilih Kategori</option>
                        <option>Berita</option>
                        <option>Event</option>
                        <option>Pengumuman</option>
                    </select>
                </div>

                <div class="col-span-12 md:col-span-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                    <input type="text" name="title" class="block w-full rounded border-gray-200 shadow-sm p-3"
                        placeholder="Tentukan judul di sini">
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konten</label>
                    <div class="border border-gray-200 rounded">
                        <!-- Editor toolbar (visual only) -->
                        <div class="bg-gray-50 border-b border-gray-200 p-2 flex items-center gap-2">
                            <button class="px-2 py-1 text-sm">B</button>
                            <button class="px-2 py-1 text-sm">I</button>
                            <button class="px-2 py-1 text-sm">U</button>
                            <button class="px-2 py-1 text-sm">•</button>
                            <button class="px-2 py-1 text-sm">"</button>
                            <div class="ml-auto text-xs text-gray-500">Tips bikin judul</div>
                        </div>

                        <!-- Editor area (placeholder only) -->
                        <textarea name="content" class="w-full p-4 min-h-[300px] text-gray-500" placeholder="Mulai tulis di sini . . .">
                        </textarea>
                    </div>
                </div>

                <div class="col-span-12 text-right mt-4">
                    <button class="inline-block px-4 py-2 bg-blue-600 text-white rounded" type="submit" style="background: rgb(110, 110, 255);
                    color:white;">Simpan</button>
                    <a href="{{ route('news.index') }}" class="inline-block px-4 py-2 ml-2 border rounded">Batal</a>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection
