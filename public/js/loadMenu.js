// simpan semua menu global
let menus = [];

// Load semua menu saat pertama kali halaman dibuka
document.addEventListener("DOMContentLoaded", () => {
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

// fungsi render menu
function renderMenus(dataMenus) {
    const menuList = document.getElementById("menu-list");
    menuList.innerHTML = "";

    if (dataMenus.length === 0) {
        menuList.innerHTML =
            '<p class="col-span-full text-center text-gray-500">Tidak ada menu ditemukan.</p>';
        return;
    }

    dataMenus.forEach((menu) => {
        let fotoUrl = menu.foto
            ? `/${menu.foto}`
            : "/img/illustrations/no-image.png";
        let html = `
            <div>
                <div class="h-80 bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition relative flex flex-col">
                    <img class="rounded-t-lg h-[11rem] w-full object-cover"
                         src="${fotoUrl}" alt="" />
                    <div class="p-4 flex flex-col justify-between flex-1">
                        <h3 class="font-semibold text-base sm:text-lg line-clamp-2 h-12">
                            ${menu.nama}
                        </h3>
                        <p class="text-purple-700 font-bold">
                            Rp ${parseInt(menu.harga).toLocaleString("id-ID")}
                        </p>
                        <button onclick="tambahKeKeranjang(event, ${menu.id}, ${menu.business_id}, ${menu.harga})"
                            class="mt-3 w-full bg-gradient-to-tl from-purple-700 to-pink-500 hover:bg-green-600 text-white py-2 rounded-lg text-sm">
                            Tambah
                        </button>
                    </div>
                </div>
            </div>`;
        menuList.innerHTML += html;
    });
}

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
