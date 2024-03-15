<?php

use App\Http\Controllers\adminAccountController;
use App\Http\Controllers\adminDashboardController;
use App\Http\Controllers\adminPortoController;
use App\Http\Controllers\portofolioPage_controller;
use App\Http\Controllers\publicPageController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/rss', 'RssController@index');

// SESSION

// PUBLIC
Route::middleware(['guest'])->group(function (){
    Route::get('/index', [SessionController::class, 'index'])->name('login');
    Route::post('/login', [SessionController::class, 'login'])->name('authenticate');
    Route::get('/dashboard', [publicPageController::class, 'dashboard'])->name('public.dashboard');
    Route::get('/showcase', [publicPageController::class, 'showcase'])->name('public.showcase');
    Route::get('/portofolio', [publicPageController::class, 'portofolio'])->name('public.portofolio');
    Route::get('/team', [publicPageController::class, 'team'])->name('public.team');
    Route::get('/TA/{id}', [publicPageController::class, 'TA'])->name('public.TA');
    Route::get('/lecturer/{id}', [publicPageController::class, 'lecturer'])->name('public.lecturer');

});

Route::get('/home', function(){
    return redirect('/admin/dashboard/porto');
});

Route::middleware(['auth'])->group( function(){
    Route::get('/logout', [SessionController::class, 'logout'])->name('session.logout');


    // ADMIN
    Route::get('/', [adminAccountController::class, 'index'])->name('account.index');
    Route::get('/kelolaakun/posts', [adminAccountController::class, 'create'])->name('account.create');
    Route::post('/kelolaakun/store', [adminAccountController::class, 'store'])->name('account.store');
    Route::get('/kelolaakun/destroy/{id}', [adminAccountController::class, 'destroy'])->name('account.destroy');
    Route::get('/kelolaakun/show/{id}', [adminAccountController::class, 'show'])->name('account.show');
    Route::get('/kelolaakun/edit_akun/{id}', [adminAccountController::class, 'edit_akun'])->name('account.edit_akun');
    Route::get('/kelolaakun/edit_profil/{id}', [adminAccountController::class, 'edit_profil'])->name('account.edit_profil');
    Route::post('/kelolaakun/update_akun/{id}', [adminAccountController::class, 'update_akun'])->name('account.update_akun');
    Route::post('/kelolaakun/update_profil/{id}', [adminAccountController::class, 'update_profil'])->name('account.update_profil');

    Route::get('/1', [adminPortoController::class, 'showAccounts'])->name('proyek.pilih_akun');
    Route::get('/kelolaproyek/pilih_akun/{id}', [adminPortoController::class, 'lihatKonten'])->name('proyek.lihat_projek');
    Route::get('/proyek/tambah_proyek/{id}', [adminPortoController::class, 'tambahProjek'])->name('proyek.tambah_projek');
    Route::post('/kelolaproyek/pilih_akun/simpan_data_projek/{id}', [adminPortoController::class, 'simpanDataProjek'])->name('proyek.simpan_data_projek');

    Route::get('/kelolaproyek/pilih_akun/lihat_detail/{id}', [adminPortoController::class, 'lihatDetail'])->name('proyek.lihat_detail');
    Route::get('/kelolaproyek/pilih_akun/edit_projek/{id}', [adminPortoController::class, 'editProjek'])->name('proyek.edit_projek');
    Route::post('/kelolaproyek/pilih_akun/update_projek/{id}', [adminPortoController::class, 'updateProjek'])->name('proyek.update_projek');

    Route::get('/kelolaproyek/pilih_akun/hapus_projek/{id}', [adminPortoController::class, 'hapusProjek'])->name('proyek.hapus_projek');

    // ADMIN DASHBOARD
    Route::get('/admin/dashboard/analytic', [adminDashboardController::class, 'showAnalytic'])->name('admin.dashboard.analytic');
    Route::get('/admin/dashboard/porto', [adminDashboardController::class, 'showPortoList'])->name('admin.dashboard.porto');
    Route::get('/admin/dashboard/member', [adminDashboardController::class, 'showMemberList'])->name('admin.dashboard.member');
    Route::get('/admin/dashboard/member/detail/{id}', [adminDashboardController::class, 'showMemberListDetail'])->name('admin.dashboard.member.detail');
    Route::get('/admin/dashboard/member/edit/{id}', [adminDashboardController::class, 'editMemberProfiles'])->name('admin.dashboard.member.edit');
    Route::post('/admin/dashboard/member/saveedit/{id}', [adminDashboardController::class, 'saveEditMemberProfiles'])->name('admin.dashboard.member.saveedit');

    // ADMIN PORTOFOLIO
    Route::get('/admin/porto/showAllPorto/', [adminPortoController::class, 'showAllPorto'])->name('admin.porto.showAllPorto');
    Route::get('/admin/porto/addPorto', [adminPortoController::class, 'addPorto'])->name('admin.porto.addPorto');
    Route::post('/admin/porto/storePorto/', [adminPortoController::class, 'storePorto'])->name('admin.porto.storePorto');
    Route::get('/admin/porto/searchPorto', [adminPortoController::class, 'searchPorto'])->name('admin.porto.searchPorto');
    Route::get('/admin/porto/delete/{id}', [adminPortoController::class, 'deletePorto'])->name('admin.porto.delete');
    Route::get('/admin/porto/update/{id}', [adminPortoController::class, 'updatePorto'])->name('admin.porto.update');
    Route::post('/admin/porto/saveUpdate/{id}', [adminPortoController::class, 'saveUpdate'])->name('admin.porto.saveupdate');

    // ADMIN ACCOUNT
    Route::get('/admin/account/showAllAccount', [adminAccountController::class, 'showAllAccount'])->name('admin.account.showAllAccount');
    Route::get('/admin/account/create', [adminAccountController::class, 'createAccount'])->name('admin.account.create');
    Route::post('/admin/account/store', [adminAccountController::class, 'storeAccount'])->name('admin.account.store');
    Route::get('/admin/account/delete/{id}', [adminAccountController::class, 'destroy'])->name('admin.account.delete');
    Route::get('/admin/account/update{id}', [adminAccountController::class, 'updateAccount'])->name('admin.account.update');
    Route::post('/admin/account/saveupdate/{id}', [adminAccountController::class, 'saveUpdate'])->name('admin.account.saveupdate');


});

?>
