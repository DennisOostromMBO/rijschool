@extends('layouts.app')

@section('title', 'Rijschool Vierkante Wielen - Home')

@section('content')
<!-- Hero Section -->
<div class="bg-blue-600 text-white py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-4">Welkom bij Rijschool Vierkante Wielen</h1>
        <p class="text-xl mb-8">De beste keuze voor je rijbewijs in Nederland</p>
        <a href="{{ route('registrations.create') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
            Meld je nu aan
        </a>
    </div>
</div>

<!-- Services Section -->
<div class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Onze Diensten</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4">Rijlessen</h3>
                <p class="mb-4">Professionele rijlessen aangepast aan jouw tempo en leerstijl.</p>
                <a href="#" class="text-blue-600 font-semibold">Meer informatie →</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4">Spoedcursus</h3>
                <p class="mb-4">Haal je rijbewijs in recordtijd met onze intensieve spoedcursus.</p>
                <a href="#" class="text-blue-600 font-semibold">Meer informatie →</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4">Pakketten</h3>
                <p class="mb-4">Voordelige pakketten voor complete rijopleidingen.</p>
                <a href="#" class="text-blue-600 font-semibold">Meer informatie →</a>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<div class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Wat Onze Leerlingen Zeggen</h2>

        <!-- Animated Testimonials Container -->
        <div class="relative overflow-hidden" style="height: 200px;">
            <div class="testimonials-slider absolute flex items-center" id="testimonials-container">
                <!-- Testimonial items will be duplicated in JavaScript for infinite loop -->
                <div class="testimonial-item flex-shrink-0 w-96 p-6 mx-4 bg-gray-50 rounded-lg shadow-md">
                    <p class="italic mb-4">"Dankzij de geduldige instructeurs van Rijschool Vierkante Wielen heb ik mijn rijbewijs in één keer gehaald!"</p>
                    <p class="font-semibold">- Lisa de Vries</p>
                </div>

                <div class="testimonial-item flex-shrink-0 w-96 p-6 mx-4 bg-gray-50 rounded-lg shadow-md">
                    <p class="italic mb-4">"De beste rijschool in de regio. Professioneel, flexibel en zeer behulpzaam."</p>
                    <p class="font-semibold">- Mark Jansen</p>
                </div>

                <div class="testimonial-item flex-shrink-0 w-96 p-6 mx-4 bg-gray-50 rounded-lg shadow-md">
                    <p class="italic mb-4">"Na een slechte ervaring bij een andere rijschool ben ik hier terecht gekomen. Wat een verschil! Echt aan te raden."</p>
                    <p class="font-semibold">- Sophie Bakker</p>
                </div>

                <div class="testimonial-item flex-shrink-0 w-96 p-6 mx-4 bg-gray-50 rounded-lg shadow-md">
                    <p class="italic mb-4">"Goede prijs-kwaliteitverhouding en vriendelijke instructeurs die altijd bereid zijn extra uitleg te geven."</p>
                    <p class="font-semibold">- Thomas van Dijk</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<div class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Over Rijschool Vierkante Wielen</h2>
        <div class="md:flex items-center gap-8">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <img src="{{ asset('images/driving-school.jpg') }}" alt="Rijschool Vierkante Wielen" class="rounded-lg shadow-md w-full h-auto" onerror="this.src='https://placehold.co/600x400?text=Rijschool+Vierkante+Wielen'">
            </div>
            <div class="md:w-1/2">
                <p class="mb-4">Bij Rijschool Vierkante Wielen streven we naar excellentie in rijonderwijs. Onze ervaren instructeurs staan klaar om jou te begeleiden op weg naar je rijbewijs.</p>
                <p class="mb-4">We bieden persoonlijke aandacht, flexibele lestijden en een hoog slagingspercentage.</p>
                <a href="#" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">Lees meer over ons</a>
            </div>
        </div>
    </div>
</div>

<!-- Contact CTA -->
<div class="py-16 bg-blue-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Klaar om te beginnen?</h2>
        <p class="text-xl mb-8">Neem vandaag nog contact met ons op voor meer informatie of om je eerste rijles te plannen.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Bel ons</a>
            <a href="{{ route('contact') }}" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">Stuur een bericht</a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Clone testimonials for infinite loop
        const container = document.getElementById('testimonials-container');
        const items = document.querySelectorAll('.testimonial-item');

        // Duplicate the testimonials
        items.forEach(item => {
            const clone = item.cloneNode(true);
            container.appendChild(clone);
        });

        // Set the animation
        const totalWidth = Array.from(items).reduce((width, item) => {
            return width + item.offsetWidth + parseInt(window.getComputedStyle(item).marginLeft) +
                parseInt(window.getComputedStyle(item).marginRight);
        }, 0);

        // Create animation
        let position = 0;
        function animate() {
            position -= 1; // Speed of animation

            // Reset position for infinite loop
            if (position <= -totalWidth) {
                position = 0;
            }

            container.style.transform = `translateX(${position}px)`;
            requestAnimationFrame(animate);
        }

        // Start animation
        animate();
    });
</script>
@endsection
