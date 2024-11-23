@extends('layouts.app')
@section('judul', 'Proposal Submission')

@section('content')
    <!-- Proposal Guide -->
    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <div style="display: flex; align-items: center;">
            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="1" y="1" width="34" height="34" rx="7" fill="white" />
                <rect x="1" y="1" width="34" height="34" rx="7" stroke="#D9D9D9" stroke-width="2" />
                <path
                    d="M20.7986 8.10639C21.1949 8.00024 21.6082 7.97318 22.0149 8.02676C22.4216 8.08034 22.8138 8.21351 23.169 8.41866C23.5243 8.62381 23.8356 8.89693 24.0853 9.22242C24.335 9.54791 24.5181 9.91939 24.6243 10.3157L27.7116 21.8357C27.8177 22.2319 27.8448 22.6452 27.7912 23.0519C27.7376 23.4586 27.6044 23.8508 27.3993 24.2061C27.1941 24.5613 26.921 24.8727 26.5955 25.1224C26.27 25.372 25.8986 25.5552 25.5023 25.6613L18.3713 27.5718C17.5712 27.7862 16.7186 27.6741 16.0012 27.26C15.2838 26.8459 14.7602 26.1638 14.5457 25.3637L11.4572 13.8425C11.3511 13.4462 11.3241 13.0329 11.3777 12.6261C11.4314 12.2193 11.5647 11.8271 11.7699 11.4718C11.9752 11.1166 12.2484 10.8052 12.574 10.5556C12.8997 10.306 13.2713 10.1229 13.6676 10.0169L20.7986 8.10639ZM11.447 18.1929L13.4484 25.6567C13.6451 26.3962 14.0384 27.0686 14.5866 27.6025L14.0834 27.5764C13.2562 27.5329 12.4801 27.1627 11.9258 26.5471C11.3716 25.9315 11.0845 25.1209 11.1278 24.2937L11.447 18.1929ZM21.2394 9.75227L14.1084 11.6628C13.9282 11.711 13.7594 11.7943 13.6114 11.9078C13.4635 12.0213 13.3393 12.1628 13.2461 12.3243C13.1529 12.4858 13.0923 12.6641 13.068 12.849C13.0437 13.0338 13.056 13.2217 13.1042 13.4018L16.1915 24.9218C16.289 25.2854 16.5268 25.5953 16.8527 25.7836C17.1785 25.9719 17.5658 26.0231 17.9294 25.9259L25.0616 24.0154C25.2417 23.9672 25.4105 23.8839 25.5585 23.7704C25.7064 23.6569 25.8306 23.5154 25.9238 23.3539C26.0171 23.1924 26.0776 23.0141 26.1019 22.8292C26.1263 22.6444 26.1139 22.4565 26.0657 22.2764L22.9784 10.7564C22.8809 10.3929 22.6431 10.0829 22.3173 9.89461C21.9914 9.70633 21.6041 9.65513 21.2405 9.75227M10.3963 16.5141L9.99309 24.2335C9.95106 25.0275 10.1294 25.7817 10.4747 26.4371L10.0045 26.2554C9.62146 26.1084 9.27117 25.8874 8.97358 25.605C8.676 25.3226 8.43695 24.9844 8.27008 24.6097C8.10322 24.2349 8.01181 23.8309 8.00107 23.4209C7.99033 23.0108 8.06048 22.6026 8.2075 22.2196L10.3963 16.5141ZM15.9212 12.9418C16.0653 12.9032 16.2156 12.8933 16.3635 12.9127C16.5114 12.9322 16.654 12.9806 16.7832 13.0551C16.9125 13.1297 17.0257 13.229 17.1165 13.3473C17.2074 13.4657 17.274 13.6008 17.3127 13.7449C17.3513 13.8889 17.3612 14.0392 17.3417 14.1872C17.3223 14.3351 17.2739 14.4777 17.1993 14.6069C17.1247 14.7361 17.0254 14.8494 16.9071 14.9402C16.7888 15.031 16.6537 15.0977 16.5096 15.1363C16.2186 15.2143 15.9085 15.1735 15.6475 15.0229C15.3866 14.8723 15.1962 14.6242 15.1181 14.3332C15.0401 14.0422 15.0809 13.7321 15.2315 13.4712C15.3821 13.2103 15.6302 13.0198 15.9212 12.9418Z"
                    fill="#6F6F6F" />
            </svg>

            <div style="margin-left: 8px;">
                <h2 class="text-lg font-semibold">Proposal Guide</h2>
                <p class="text-gray-600">All proposals that recently added to your plate</p>
            </div>
        </div>

        <hr class="my-2 border-gray-300" />

        <ul class="list-none ml-2 mt-2">
            <p>Get started by following these two easy steps to submit your proposal title :</p>
            <li>📝 For those aiming for the Proposal Organization, check out our detailed <a href="#"
                    class="text-blue-500 underline">Technical Instructions for Proposal Organization</a></li>
            <li>📚 Make your life easier with our proposal title templates <a href="#"
                    class="text-blue-500 underline">Proposal Organization Template</a></li>
        </ul>
    </div>

    <!-- Proposal Submission Form -->
    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="1" y="1" width="34" height="34" rx="6.33333" fill="white" />
                    <rect x="1" y="1" width="34" height="34" rx="6.33333" stroke="#D9D9D9" stroke-width="2" />
                    <path
                        d="M25.4444 13.5556V18.8889C25.4444 22.2409 25.4444 23.9174 24.4026 24.9583C23.3608 25.9992 21.6853 26.0001 18.3333 26.0001H17.4444C14.0924 26.0001 12.4159 26.0001 11.375 24.9583C10.3341 23.9165 10.3333 22.2409 10.3333 18.8889V13.5556"
                        stroke="#6F6F6F" stroke-width="1.33333" stroke-linecap="round" />
                    <path
                        d="M9 11.7778C9 10.9396 9 10.5209 9.26044 10.2604C9.52089 10 9.93956 10 10.7778 10H25C25.8382 10 26.2569 10 26.5173 10.2604C26.7778 10.5209 26.7778 10.9396 26.7778 11.7778C26.7778 12.616 26.7778 13.0347 26.5173 13.2951C26.2569 13.5556 25.8382 13.5556 25 13.5556H10.7778C9.93956 13.5556 9.52089 13.5556 9.26044 13.2951C9 13.0347 9 12.616 9 11.7778Z"
                        stroke="#6F6F6F" stroke-width="1.33333" />
                    <path d="M15.6666 19.2445L16.9368 20.6667L20.1111 17.1111" stroke="#6F6F6F" stroke-width="1.33333"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="ml-2">
                    <h2 class="text-xl font-semibold">Proposal Submission</h2>
                    <p class="text-gray-600">Proposals awaiting review and potential approval</p>
                </div>
            </div>
        </div>
        <hr class="my-4 border-gray-300" />
        <form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf
            <div class="mb-4">
                <label for="title" class="block font-semibold text-gray-700">Proposal Title</label>
                <input type="text" name="title" id="title"
                    class="w-full border border-gray-300 rounded mt-1 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Proposal title" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block font-semibold text-gray-700">Proposal Description</label>
                <textarea name="description" id="description"
                    class="w-full border border-gray-300 rounded mt-1 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Short description about the organizational proposal" required></textarea>
            </div>

            <div class="mb-4">
                <label for="event_date" class="block font-semibold text-gray-700">Event Date</label>
                <input type="date" name="event_date" id="event_date"
                    class="w-full border border-gray-300 rounded mt-1 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="type" class="block font-semibold text-gray-700">Type of Activity</label>
                <select name="type" id="type"
                    class="w-full border border-gray-300 rounded mt-1 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="internal">Internal</option>
                    <option value="external">External</option>
                </select>
            </div>
            

            <div class="mb-4">
                <label for="file" class="block font-semibold text-gray-700">Upload Proposal</label>
                <input type="file" name="file" id="file"
                    class="w-full border-gray-300 rounded mt-1 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    accept=".pdf" required>
                <p class="text-gray-500 text-sm mt-1">Supported format: PDF. Maximum size: 25MB</p>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-strong-blue text-white py-2 px-6 rounded hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Submit</button>
            </div>
        </form>
    </div>
@endsection
