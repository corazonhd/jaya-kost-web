@extends('layouts.app')

@section('title', 'Galeri - Jaya Kost Group')

@section('content')
<div class="page-wrapper">
    <div class="container with-top-padding">
        <section class="hero-section">
            <div class="hero-slideshow">
                @foreach(['A','B','C'] as $blok)
                    @foreach(\App\Models\Gallery::where('blok', $blok)->get() as $gallery)
                        @if(!empty($gallery->image_url))
                            <img src="{{ $gallery->image_url }}" 
                                 alt="{{ $gallery->title ?? 'No Title' }}" 
                                 class="hero-slide blok-{{ $blok }}">
                        @endif
                    @endforeach
                @endforeach
            </div>
            <div class="hero-dots"></div>
        </section>

        <div class="gallery-filter-buttons mt-4 flex gap-2">
            <button class="filter-btn active px-4 py-2 bg-cyan-500 text-white rounded" data-filter="blok-A">Blok A</button>
            <button class="filter-btn px-4 py-2 bg-gray-700 text-white rounded" data-filter="blok-B">Blok B</button>
            <button class="filter-btn px-4 py-2 bg-gray-700 text-white rounded" data-filter="blok-C">Blok C</button>
        </div>
    </div>
</div>

<script>
    const filterBtns = document.querySelectorAll('.filter-btn');
    const slides = document.querySelectorAll('.hero-slide');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-filter');

            slides.forEach(slide => {
                slide.style.display = slide.classList.contains(filter) ? 'block' : 'none';
            });

            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    // Tampilkan default Blok A
    slides.forEach(slide => slide.style.display = slide.classList.contains('blok-A') ? 'block' : 'none');
</script>

<style>
.hero-slide { display: none; width: 100%; height: auto; margin-bottom: 1rem; border-radius: 0.5rem; }
.hero-slideshow { display: flex; flex-wrap: wrap; gap: 1rem; }
</style>
@endsection
