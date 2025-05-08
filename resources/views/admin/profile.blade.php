@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Profile')
@section('admin')
    <div class="relative flex items-center p-0 mt-0 overflow-hidden bg-center bg-cover min-h-75 rounded-2xl"
        style="background-image: url('{{ asset('img/curved-images/curved0.jpg') }}'); background-position-y: 50%">
        <span
            class="absolute inset-y-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-purple-700 to-pink-500 opacity-60"></span>
    </div>

    <div
        class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 -mt-16 overflow-hidden break-words border-0 shadow-blur rounded-2xl bg-white/80 bg-clip-border backdrop-blur-2xl backdrop-saturate-200">
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-auto max-w-full px-3">
                <div
                    class="text-base ease-soft-in-out h-18.5 w-18.5 relative inline-flex items-center justify-center rounded-xl text-white transition-all duration-200">
                    <img src="{{ asset('img/bruce-mars.jpg') }}" alt="profile_image"
                        class="w-full shadow-soft-sm rounded-xl" />
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1 text-lg">{{ $user->name }}</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm">{{ $user->role }}</p>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mx-auto mt-4 sm:my-auto sm:mr-0 md:w-1/2 md:flex-none lg:w-4/12">
                <div class="relative right-0">
                    {{-- Code --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Settings & Profile --}}
    <div class="flex flex-wrap -mx-3 mt-6">
        {{-- Platform Settings --}}
        <div class="w-full max-w-full px-3 xl:w-4/12">
            <div
                class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Platform Settings</h6>
                </div>
                <div class="flex-auto p-4">
                    {{-- Account Settings --}}
                    <h6 class="font-bold leading-tight uppercase text-xs text-slate-500">Account</h6>
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        <li class="relative block px-0 py-2 bg-white border-0 rounded-t-lg text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="answer"
                                    class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                    type="checkbox" />
                                <label for="follow" class="px-4">Email me when someone follows me</label>
                            </div>
                        </li>
                        <li class="relative block px-0 py-2 bg-white border-0 text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="answer"
                                    class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                    type="checkbox" />
                                <label for="answer" class="px-4">Email me when someone answers on my post</label>
                            </div>
                        </li>
                        <li class="relative block px-0 py-2 bg-white border-0 rounded-b-lg text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="answer"
                                    class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                    type="checkbox" />
                                <label for="mention" class="px-4">Email me when someone mentions me</label>
                            </div>
                        </li>
                    </ul>

                    {{-- Application Settings --}}
                    <h6 class="mt-6 font-bold leading-tight uppercase text-xs text-slate-500">Application</h6>
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        <li class="relative block px-0 py-2 bg-white border-0 rounded-t-lg text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="answer"
                                    class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                    type="checkbox" />
                                <label for="launches_projects" class="px-4">New launches and projects</label>
                            </div>
                        </li>
                        <li class="relative block px-0 py-2 bg-white border-0 text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="answer"
                                    class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                    type="checkbox" />
                                <label for="product_updates" class="px-4">Monthly product updates</label>
                            </div>
                        </li>
                        <li class="relative block px-0 py-2 pb-0 bg-white border-0 rounded-b-lg text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="answer"
                                    class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                    type="checkbox" />
                                <label for="subscribe" class="px-4">Subscribe to newsletter</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Profile Information --}}
        <div class="w-full max-w-full px-3 lg-max:mt-6 xl:w-4/12">
            <div
                class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-none">
                            <h6 class="mb-0">Profile Information</h6>
                        </div>
                        <div class="w-full max-w-full px-3 text-right shrink-0 md:w-4/12 md:flex-none">
                            <a href="javascript:;" data-target="tooltip_trigger" data-placement="top">
                                <i class="leading-normal fas fa-user-edit text-sm text-slate-400"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-4">
                    <p class="leading-normal text-sm">Hi, I’m {{ $user->name }}, Decisions: If you can’t decide, the
                        answer is no...</p>
                    <hr class="h-px my-6 bg-transparent bg-gradient-to-r from-transparent via-white to-transparent" />
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        <li
                            class="relative block px-4 py-2 pt-0 pl-0 leading-normal bg-white border-0 rounded-t-lg text-sm text-inherit">
                            <strong class="text-slate-700">Full Name:</strong> &nbsp; {{ $user->name }}
                        </li>
                        <li
                            class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Email:</strong> &nbsp; {{ $user->email }}
                        </li>
                        <li
                            class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Role:</strong> &nbsp; {{ $user->role }}
                        </li>
                    </ul>
                    <button
                        class="z-10 flex items-center justify-center px-6 py-3 mt-3 font-bold text-center text-white uppercase transition-all border-0 rounded-lg shadow-md cursor-pointer leading-pro text-xs ease-soft-in bg-150 bg-gradient-to-tl from-blue-600 to-purple-500 hover:scale-105 active:opacity-85"
                        type="button"
                        onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')">
                        <i class="mr-2 far fa-edit"></i> Edit
                    </button>
                </div>
            </div>
        </div>

        {{-- Conversations --}}
        <div class="w-full max-w-full px-3 lg-max:mt-6 xl:w-4/12">
            <div
                class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Conversations</h6>
                </div>
                <div class="flex-auto p-4">
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        <li class="relative flex items-center px-0 py-2 mb-2 bg-white border-0 rounded-t-lg text-inherit">
                            <div
                                class="inline-flex items-center justify-center w-12 h-12 mr-4 text-white transition-all duration-200 text-base ease-soft-in-out rounded-xl">
                                <img src="../assets/img/kal-visuals-square.jpg" alt="kal"
                                    class="w-full shadow-soft-2xl rounded-xl" />
                            </div>
                            <div class="flex flex-col items-start justify-center">
                                <h6 class="mb-0 leading-normal text-sm">Sophie B.</h6>
                                <p class="mb-0 leading-tight text-xs">Hi! I need more information..</p>
                            </div>
                            <a class="inline-block py-3 pl-0 pr-4 mb-0 ml-auto font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in hover:scale-102 hover:active:scale-102 active:opacity-85 text-fuchsia-500 hover:text-fuchsia-800 hover:shadow-none active:scale-100"
                                href="javascript:;">Reply</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal Script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openEditModal(userId, userName, userEmail) {
            Swal.fire({
                title: 'Edit User',
                html: `
                <form id="editForm" method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    <div style="text-align: left;">
                        <label for="swal-name" class="mb-1 ml-1 font-normal cursor-pointer select-none text-sm text-slate-700">Full Name</label>
                        <input id="swal-name" name="name" class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Full Name" value="${userName}" required>
                    </div>
                    <div style="text-align: left; margin-top: 10px;">
                        <label for="swal-email" class="mb-1 ml-1 font-normal cursor-pointer select-none text-sm text-slate-700">Email</label>
                        <input id="swal-email" name="email" class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Email" value="${userEmail}" required>
                    </div>
                </form>`,
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline',
                    cancelButton: 'bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline',
                },
                preConfirm: () => {
                    document.getElementById('editForm').submit();
                }
            });
        }
    </script>
@endsection
