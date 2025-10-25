@extends('layouts.app')
@section('title', 'Ekstrakulikuler')
@section('content')
<div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">

    <div class="container mx-auto p-6">
        <div class="max-w-4xl mx-auto bg-white rounded shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-semibold">Daftar Ekstrakulikuler</h2>
                <a href="{{ route('extrakulikuler.create') }}" class="btn btn-primary">Tambah Ekstrakulikuler</a>
            </div>

            @if (isset($extracurriculars) && $extracurriculars->count())
                <table id="rowBorder" class="w-full">
                    <thead>
                        <tr>
                            <th class="p-2 text-left">Nama</th>
                            <th class="p-2 text-left">Foto</th>
                            <th class="p-2 text-left">Menu</th>
                            <th class="p-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($extracurriculars as $ex)
                            <tr>
                                <td class="p-2">{{ $ex->name }}</td>
                                <td class="p-2">
                                    @if ($ex->photo)
                                        <img src="{{ asset('storage/' . $ex->photo) }}" alt="photo" class="h-12">
                                    @endif
                                </td>
                                <td class="p-2">{{ $ex->menu?->name ?? '-' }}</td>
                                <td class="p-2">
                                    <a href="{{ route('extrakulikuler.edit', $ex->id) }}"
                                        class="text-green-600 mr-2">Edit</a>
                                    <form action="{{ route('extrakulikuler.destroy', $ex->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $extracurriculars->links() }}</div>
            @else
                <div class="py-12 text-center">Belum ada ekstrakulikuler</div>
            @endif
        </div>
    </div>
    </div>
@endsection
