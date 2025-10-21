@extends('layouts.app')
@section('title', 'Index Berita')
@section('content')
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">

        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Datatable</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Tables</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                        Datatable
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center justify-between mb-4">
                            <h6 class="text-15 font-medium btn">Daftar Berita</h6>
                            <a href="{{ route('news.create') }}" class="btn btn-primary"
                                style="background: rgb(111, 111, 255);
                            color:aliceblue">Tambah
                                Berita</a>
                        </div>

                        @if (isset($news) && $news->count())
                            <table id="rowBorder" class="w-full">
                                <thead>
                                    <tr>
                                        <th class="text-left p-2">Judul</th>
                                        <th class="text-left p-2">Dipublikasi</th>
                                        <th class="text-left p-2">Dibuat</th>
                                        <th class="text-left p-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 dark:divide-zink-500">
                                    @foreach ($news as $n)
                                        <tr>
                                            <td class="p-2">{{ $n->title }}</td>
                                            <td class="p-2">{{ $n->is_published ? 'Ya' : 'Tidak' }}</td>
                                            <td class="p-2">
                                                {{ $n->created_at ? $n->created_at->format('Y-m-d H:i') : '-' }}</td>
                                            <td class="p-2">
                                                <a href="{{ route('news.show', $n->id) }}"
                                                    class="text-sm text-blue-600 mr-2">Lihat</a>
                                                <a href="{{ route('news.edit', $n->id) }}"
                                                    class="text-sm text-green-600 mr-2">Edit</a>
                                                <form action="{{ route('news.destroy', $n->id) }}" method="POST"
                                                    class="inline-block" onsubmit="return confirm('Hapus berita ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-600">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4">
                                {{ $news->links() }}
                            </div>
                        @else
                            <!-- Empty state -->
                            <div class="py-12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4" width="80" height="80"
                                    viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" y1="15" x2="12" y2="3" />
                                </svg>
                                <h3 class="text-lg font-semibold mb-2">Belum ada berita</h3>
                                <p class="text-sm text-slate-500 mb-4">Belum ada berita yang dibuat. Klik tombol "Tambah
                                    Berita" untuk membuat berita baru.</p>
                                <a href="{{ route('news.create') }}"
                                    class="inline-block px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah
                                    Berita</a>
                            </div>
                        @endif
                    </div>
                </div><!--end card-->
                </div>
            @endsection
