@extends('layouts.app')
@section('content')

@section('title', "Placeholder Images from Google Street View | Eyeshot")

<div class="eyeshot-placeholder">
    <section class="pt-4 pt-md-11 eyeshot-banner">
        <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-7 col-lg-6 text-md-left banner-text">
                <h2 class="text-center text-md-left">
                    Placeholders from Google Street View.
                </h2>
                <p class="lead text-md-left text-center mb-6 mb-lg-8">
                    Random and beautiful placeholders from Google Street View
                </p>

                <div class="text-center text-md-left mb-4">
                    <a href="#documentation" class="button-es btn mt-1">Documentation</a>
                </div>

            </div>
            <div class="col-12 col-md-5 col-lg-6 banner-image text-center">
                <img class="banner-image img-fluid shadow rounded-lg" src="https://eyeshot.xyz/shots" alt="eyeshot-placeholder">
            </div>
        </div>
        </div>
    </section>

    <div id="documentation" class="documentation">
        <div class="row">
        <nav class="col-md-3 d-none d-md-block d-lg-block col-sm-none docs-links" id="placeholderScrollspy">
            <ul class="nav nav-pills flex-column mt-5">
                <li class="nav-item">
                    <a class="nav-link active" href="#introduction">Introduction</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#size">Size</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#search">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#imageById">Image By ID</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#randomImage">Random Image</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#grayscale">Grayscale</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#blur">Blur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#grayscale-blur">Grayscale & Blur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#imageByProfile">Image from Particular Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#more-options">More</a>
                </li>
            </ul>
        </nav>
        <div class="col-md-9 col-sm-12 docs shadow-sm">
            <div class="docs-section mt-5" id="introduction">
                <h2 class="docs-title">Introduction</h2>
                <p>Images are explored by people on Eyeshot using Google Street View. All the images are from Google Street View and Eyeshot is not affiliated with Google.</p>
                <p>Get beautiful, random, funny, and cool images by using the links below for your placeholders.</p>
            </div>

            <div class="docs-section" id="size">
                <h2 class="docs-title">Size</h2>
                <p>Get the image of the desired size by giving the size in the URL. Default is <strong>640x480</strong></p>
                <pre><code><a href="https://eyeshot.xyz/shots/400x300">https://eyeshot.xyz/shots/400x300</a></code></pre>
                <p>Get the square image by</p>
                <pre><code><a href="https://eyeshot.xyz/shots/400/">https://eyeshot.xyz/shots/400/</a></code></pre>
            </div>

            <div class="docs-section" id="search">
                <h2 class="docs-title">Search</h2>
                <p>You can search for an image by adding a <strong>query parameter</strong>.</p>
                <pre><code><a href="https://eyeshot.xyz/shots?q=nature">https://eyeshot.xyz/shots?q=nature</a></code></pre>
                <p>For searching more than one word, just <strong>concatenate (+)</strong> them.</p>
                <pre><code><a href="https://eyeshot.xyz/shots/400x200?q=burj+khalifa">https://eyeshot.xyz/shots/400x200?q=burj+khalifa</a></code></pre>
            </div>

            <div class="docs-section" id="imageById">
                <h2 class="docs-title">Image By Image ID</h2>
                <p>Every image has an ID attached. To get an image's ID, just add a param <kbd>?id=true</kbd> with the URL. And find the image ID on the top left corner of the image.</p>
                <pre><code><a href="https://eyeshot.xyz/feed?id=true">https://eyeshot.xyz/feed?id=true</a></code></pre>
                <p>The above parameter will enable the ID on any page.</p>
                <p>And use the ID in the placeholder URL.</p>
                <pre><code><a href="https://eyeshot.xyz/shots?image={IMAGEID}">https://eyeshot.xyz/shots?image={IMAGEID}</a></code></pre>
                <p>Where <kbd>{IMAGEID}</kbd> is the ID you copied. (Use without braces)</p>
            </div>

            <div class="docs-section" id="randomImage">
                <h2 class="docs-title">Random Image</h2>
                <p>Get a random image by a simple short URL</p>
                <pre><code><a href="https://eyeshot.xyz/shots">https://eyeshot.xyz/shots</a></code></pre>
            </div>

            <div class="docs-section" id="grayscale">
                <h2 class="docs-title">Grayscale</h2>
                <p>Get a grayscale image by adding <kbd>?grayscale=1</kbd> parameter</p>
                <pre><code><a href="https://eyeshot.xyz/shots?grayscale=1">https://eyeshot.xyz/shots?grayscale=1</a></code></pre>
            </div>

            <div class="docs-section" id="blur">
                <h2 class="docs-title">Blur</h2>
                <p>Get a blurred out image by adding <kbd>?blur=1</kbd> parameter</p>
                <pre><code><a href="https://eyeshot.xyz/shots?blur=1">https://eyeshot.xyz/shots?blur=1</a></code></pre>
            </div>

            <div class="docs-section" id="grayscale-blur">
                <h2 class="docs-title">Grayscale & Blur</h2>
                <p>Get both blurred out and grayscaled image by adding <kbd>?blur=1&grayscale=1</kbd> parameter</p>
                <pre><code><a href="https://eyeshot.xyz/shots?blur=1&grayscale=1">https://eyeshot.xyz/shots?blur=1&grayscale=1</a></code></pre>
            </div>
            
            <div class="docs-section" id="imageByProfile">
                <h2 class="docs-title">Image From Particular Profile</h2>
                <p>Get a random image from a particular profile by adding the <kbd>?u={USERNAME}</kbd> parameter</p>
                <pre><code><a href="https://eyeshot.xyz/shots?u=eyeshotHQ">https://eyeshot.xyz/shots?u=eyeshotHQ</a></code></pre>
            </div>

            <div class="docs-section" id="more-options">
                <h2 class="docs-title">More</h2>
                <p>More options coming soon. Until then keep <a href="https://eyeshot.xyz">exploring</a> 🌏</p>
                <p>Found a typo? Have ideas? Wanna contribute? Eyeshot and it's API is <a href="https://github.com/actuallyakash/eyeshot">Open Source</a>.</p>
                <pre><code><a href="https://eyeshot.xyz">https://eyeshot.xyz</a></code></pre>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection