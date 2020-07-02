<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    </head>
    <body>
        <div class="container mx-auto py-16 px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <form class="relative" id="new-post" action="/posts" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h1 class="text-3xl font-semibold mb-6">Publish a post</h1>
                    <div class="mb-4 flex">
                        <input type="text" name="title" placeholder="Give a title..." class="rounded border block w-full py-1 px-2 shadow-sm hover:shadow-md focus:outline-none text-gray-600">
                    </div>
                    <div class="flex mb-4">
                        <textarea name="body" id="" cols="30" rows="10" placeholder="Start writing here"
                            class="rounded border block w-full py-1 px-2 shadow-sm hover:shadow-md focus:outline-none text-gray-600"></textarea>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-2">Upload a cover</h3>
                        <div class="relative h-56 border-dashed border-4 flex items-center justify-center hover:border-indigo-500 text-gray-500 cursor-pointer hover:bg-gray-100 hover:text-indigo-500">
                            <span class="text-lg font-sans">Drop your file here</span>
                            <input type="file" name="cover" class="opacity-0 cursor-pointer w-full inset-0 absolute top-0 left-0">
                        </div>
                        <div class="">
                            <h3 class="">Nom du fichier : <strong class="" id="filename"></strong></h3>
                            <a href="#" target="_blank" download="hello" class="rounded-md bg-indigo-600 text-white py-2 px-6 hover:shadow-md hover:bg-indigo-400 inline-block" id="download">Download</a>
                            <img src="" alt="   " class="" id="preview">
                        </div>
                    </div>
                    <div class="flex items-center justify-end">
                        <button class="rounded-md bg-indigo-600 text-white py-2 px-6 hover:shadow-md hover:bg-indigo-400">Publish your story</button>
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center hidden" id="progress">
                        <span class="absolute inset-0 bg-white opacity-75"></span>
                        <h1 class="text-3xl relative font-bold">Chargement en cours...</h1>
                    </div>
                </form>
                <div class="overflow-y-auto">
                    <h1 class="mb-3 pb-3 border-b font-semibold text-3xl text-gray-600">Recent posts</h1>
                    <div id="posts">
                        Chargement en cours...
                    </div>
                </div>
            </div>
        </div>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script>
            let fetchRecentPosts = (callback) => {
                axios.get("/recently").then(({data}) => {
                    // console.error(response);
                    document.querySelector("#posts").innerHTML = data;
                    if (callback) {
                        callback();
                    }
                })
            }
            fetchRecentPosts();

            let data = {};
            let form = document.querySelector("#new-post");
            let preview = document.querySelector("#preview");
            let showProgress = (showing) => {
                let progress = document.querySelector("#progress");
                if (showing) {
                    progress.classList.remove("hidden");
                    return;
                }

                progress.classList.add("hidden");
            }

            document.querySelector("input[name=cover]").addEventListener("change", e => {
                let file = e.target.files[0];
                if (!file) {
                    return;
                }

                showProgress(true);

                data.cover = file;
                document.querySelector("#filename").textContent = file.name;
                let reader = new FileReader();

                reader.onloadend = function(url) {
                    console.error(url);
                    preview.setAttribute("src", url.target.result)
                    setTimeout(() => {
                        showProgress(false);
                    }, 3000);
                }

                reader.readAsDataURL(file);

                const url = URL.createObjectURL(file);
                document.querySelector("#download").setAttribute("download", file.name);
                document.querySelector("#download").setAttribute("href", url);
            });

            form.addEventListener("submit", (event) => {
                event.preventDefault();
                let formData = new FormData();

                data.title = document.querySelector("input[name=title]").value;
                data.body = document.querySelector("textarea[name=body]").value;

                formData.append("title", data.title);
                formData.append("body", data.body);
                formData.append("cover", data.cover);

                showProgress(true);

                axios.post("/posts", formData).then(({data}) => {
                    showProgress(false);
                    fetchRecentPosts();
                }).catch(error => {
                    console.error("Unable to store your story");
                    showProgress(false);
                })
            });
        </script>
    </body>
</html>
