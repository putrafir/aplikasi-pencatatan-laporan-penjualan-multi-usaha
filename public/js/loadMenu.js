// simpan semua menu global
let menus = [];
let viewMode = localStorage.getItem("viewMode") || "card";

// Fungsi ubah mode tampilan
function setViewMode(mode) {
    viewMode = mode;

    localStorage.setItem("viewMode", mode);

    renderMenus(menus);
}

// Fungsi render menu
function renderMenus(dataMenus) {
    const menuList = document.getElementById("menu-list");
    menuList.innerHTML = "";

    if (dataMenus.length === 0) {
        menuList.innerHTML = `
            <p class="col-span-full text-center text-gray-500">
                Tidak ada menu ditemukan.
            </p>`;
        return;
    }

    if (viewMode === "card") {
        menuList.className = "max-w-5xl mx-auto p-4 grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-4";
        dataMenus.forEach(menu => {
            const fotoUrl = menu.foto ? `/${menu.foto}` : "/img/illustrations/no-image.png";
            menuList.innerHTML += `
                <div class="h-80 bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition relative flex flex-col">
                    <img class="rounded-t-lg h-[11rem] w-full object-cover" src="${fotoUrl}" alt="" />
                    <div class="p-4 flex flex-col justify-between flex-1">
                        <h3 class="font-semibold text-base sm:text-lg line-clamp-2 h-12">${menu.nama}</h3>
                        <p class="text-purple-700 font-bold">Rp ${parseInt(menu.harga).toLocaleString("id-ID")}</p>
                        <button onclick="tambahKeKeranjang(event, ${menu.id}, ${menu.business_id}, ${menu.harga})"
                                class="mt-3 w-full bg-gradient-to-tl from-purple-700 to-pink-500 text-white py-2 rounded-lg text-sm">
                            Tambah
                        </button>
                    </div>
                </div>`;
        });
    } else {
        menuList.className = "max-w-5xl mx-auto p-4";

        let wrapper = `
    <div class="bg-white shadow-md rounded-xl divide-y">
`;

        dataMenus.forEach(menu => {
            const fotoUrl = menu.foto ? `/${menu.foto}` : "/img/illustrations/no-image.png";

            wrapper += `
        <div class="flex items-center p-4">
            <div class="flex-shrink-0">
                <img src="${fotoUrl}" class="w-20 h-20 object-cover rounded-lg" alt="${menu.nama}">
            </div>

            <div class="flex-1 ml-4">
                <h3 class="font-semibold text-sm md:text-base text-gray-800 line-clamp-2">
                    ${menu.nama}
                </h3>
                <p class="text-purple-700 font-bold mt-1">
                    Rp ${parseInt(menu.harga).toLocaleString("id-ID")}
                </p>
            </div>

            <div class="ml-3">
                <button onclick="tambahKeKeranjang(event, ${menu.id}, ${menu.business_id}, ${menu.harga})"
                    class="bg-gradient-to-tl from-purple-700 to-pink-500 hover:opacity-90 text-white 
                    px-4 py-2 rounded-xl text-sm md:text-base font-semibold shadow-md transition-transform hover:scale-105">
                    Tambah
                </button>
            </div>
        </div>
    `;
        });

        wrapper += `</div>`;

        menuList.innerHTML = wrapper;
    }
}

// Load semua menu saat pertama kali halaman dibuka
document.addEventListener("DOMContentLoaded", () => {
    
    document.getElementById("view-mode").value = viewMode;

    setViewMode(viewMode);

    loadMenus("all", document.querySelector(".kategori-btn"));
});

// fungsi search
const searchForm = document.getElementById("search-input");
const searchInput = document.getElementById("default-search");

searchForm.addEventListener("submit", function (e) {
    e.preventDefault(); // biar nggak reload halaman

    let keyword = searchInput.value.toLowerCase();

    // filter menu berdasarkan nama
    let filteredMenus = menus.filter(menu =>
        menu.nama.toLowerCase().includes(keyword)
    );

    // render ulang hanya menu yang sesuai
    renderMenus(filteredMenus);
});

// fungsi tombol kategori aktif
function setActiveButton(button) {
    document.querySelectorAll(".kategori-btn").forEach((btn) => {
        btn.classList.remove("bg-pink-500", "text-white");
        btn.classList.add("bg-gray-200", "text-gray-700");
    });
    button.classList.remove("bg-gray-200", "text-gray-700");
    button.classList.add("bg-pink-500", "text-white");
}

// fungsi load menu dari server
function loadMenus(kategoriId, buttonElement) {
    if (buttonElement) {
        setActiveButton(buttonElement);
    }

    let url =
        kategoriId === "all"
            ? "/pegawai/get-all-menus"
            : `/pegawai/get-menus/${kategoriId}`;

    fetch(url)
        .then((res) => res.json())
        .then((response) => {
            menus = response.menus || []; // simpan global
            renderMenus(menus); // tampilkan menu
        });
}

// fungsi tambah ke keranjang
let jumlahItemDiKeranjang = 0;

function tambahKeKeranjang(event, menuId, businessId, hargaSatuan) {
    event.preventDefault();

    const parentDiv = event.target.closest(".h-80");
    const selectEl = parentDiv ? parentDiv.querySelector("select") : null;
    const ukuran = selectEl ? selectEl.value : null;

    const hargaText = selectEl
        ? selectEl.selectedOptions[0].textContent
        : hargaSatuan;
    const hargaParsed = selectEl
        ? parseInt(hargaText.replace(/[^\d]/g, ""))
        : hargaSatuan;

    const dataKeranjang = {
        menu_id: menuId,
        business_id: businessId,
        jumlah: 1,
        harga_satuan: hargaParsed,
        ukuran: ukuran,
        total_harga: hargaParsed,
    };

    fetch("/pegawai/keranjang/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify(dataKeranjang),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                jumlahItemDiKeranjang++;
                const badge = document.getElementById("cart-badge");
                badge.textContent = jumlahItemDiKeranjang;
                badge.classList.remove("hidden");

                // ✅ tampilkan notifikasi
                showPopup("Menu berhasil ditambahkan ke keranjang!", "success");
            } else {
                showPopup(data.message || "Gagal menambahkan item ke keranjang.", "error");
                if (data.errors) {
                    console.error("Error validasi:", data.errors);
                }
            }
        })
        .catch(() => {
            showPopup("Terjadi kesalahan koneksi ke server.", "error");
        });
}
