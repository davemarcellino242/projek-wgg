<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="Assets/Css/Custom.css">
    <title>Card Generator</title>
</head>
<body>
    <div class="container-fluid header vh-100 d-flex justify-content-center align-items-center">
        <h1 class="text-white text-center fs-xxl-150 font-custom">BEYOND</h1>
    </div>
    <div class="container-fluid py-5 bg-2">
        <div class="container py-5">
            <div class="row justify-content-between">
                <div class="col-lg-6 align-content-center pe-5 ps-0 d-flex align-items-center justify-content-start" data-aos="fade-right">
                    <div class="">
                        <h1 class="text-center font-custom text-white fs-xxl-60">BEYOND REASONABLE DOUBT
                        </h1>
                        <p class="text-center poppins mt-4 text-white fs-xxl-20">"Dunia penuh dengan tantangan, tetapi potensi yang telah diberikan Tuhan kepadamu lebih besar daripada segala hambatan yang menghadang. Beranilah melangkah lebih jauh!"</p>
                    </div>
                    </div>
                <div class="col-lg-5" data-aos="fade-left">
                    <div class="card card-generate border-ungu rounded-4">
                        <div class="card-header px-5 py-3">
                            <h2 class="font-custom text-ungu">Add Content</h2>
                        </div>
                        <div class="card-body p-5">
                            <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="basic-url" class="form-label fw-bold fs-xxl-20 text-ungu">Judul</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="basic-url" name="judul" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="basic-url" class="form-label fw-bold fs-xxl-20 text-ungu">Media</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="media">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="basic-url" class="form-label fw-bold fs-xxl-20 text-ungu">Deskripsi</label>
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="deskripsi" style="height: 200px" required></textarea>
                                        <label for="floatingTextarea2">Comments</label>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-outline-success">Save Card</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row p-5">
            @forelse ($cardContents as $cardContent)
                <div class="col-lg-3 mt-4" data-aos="fade-up" id="followup">
                    <div class="card card-content rounded-4" data-bs-toggle="modal" data-bs-target="#cardModal{{ $cardContent->id }}">
                        <div class="card-body card-img">
                            <img class="img-fluid" src="{{ asset('storage/images/' . $cardContent->images) }}" alt="images">
                        </div>
                        <div class="card-footer foot-content">
                            <h4>{{ $cardContent->judul }}</h4>
                            <p>{{ Str::limit($cardContent->deskripsi, 100) }}</p>

                        </div>
                    </div>
                </div>
                <div class="modal fade" id="cardModal{{ $cardContent->id }}" tabindex="-1" aria-labelledby="cardModalLabel{{ $cardContent->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cardModalLabel{{ $cardContent->id }}">{{ $cardContent->judul }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img class="img-fluid" src="{{ asset('storage/images/' . $cardContent->images) }}" alt="image">
                                <p>{{ $cardContent->deskripsi }}</p>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $cardContent->id }}">Edit</button>
                                <form action="{{ route('content.destroy', $cardContent->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $cardContent->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $cardContent->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $cardContent->id }}">Edit {{ $cardContent->judul }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form Edit -->
                                <form action="{{ route('content.update', $cardContent->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Input untuk Judul -->
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul</label>
                                        <input type="text" class="form-control" id="judul" name="judul" value="{{ $cardContent->judul }}" required>
                                    </div>

                                    <!-- Input untuk Gambar -->
                                    <div class="mb-3">
                                        <label for="media" class="form-label">Gambar</label>
                                        <input type="file" class="form-control" id="media" name="media">
                                        <img src="{{ asset('storage/images/' . $cardContent->images) }}" alt="Current Image" class="img-fluid mt-2" style="max-width: 150px;">
                                    </div>

                                    <!-- Input untuk Deskripsi -->
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $cardContent->deskripsi }}</textarea>
                                    </div>

                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="submit" class="btn btn-outline-success">Update</button>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="row p-5">
                    <div class="col-12 text-center">
                        <p class="text-white fw-semibold">Tidak ada kartu yang tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <footer class="bg-1 py-1">
        <p class="text-center text-white mt-1">Copyright design & develop by Dave</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        AOS.init();
      </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('.card-content');
    const modalTitle = document.getElementById('cardModalLabel');
    const modalImage = document.getElementById('modalImage');
    const modalDescription = document.getElementById('modalDescription');

    cards.forEach(card => {
        card.addEventListener('click', function() {
            const title = card.querySelector('h4').innerText;
            const imageSrc = card.querySelector('img').src;
            const description = card.querySelector('p').innerText;

            // Set modal content
            modalTitle.innerText = title;
            modalImage.src = imageSrc;
            modalDescription.innerText = description;
        });
    });
});

    </script>
</body>
</html>
