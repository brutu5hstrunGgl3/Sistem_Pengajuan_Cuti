<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Pengajuan Cuti </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Course</a>
        </div>
        <ul class="sidebar-menu">


           
            @if(auth()->user()->role == 'ADMIN' || auth()->user()->role == 'ATASAN')
<li class="nav-item dropdown ">
    <a href="#" class="nav-link has-dropdown"> <i class="fas fa-fire"></i><span>User</span></a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link" href="{{route('user.index')}}">Tambah User</a>
        </li>

    </ul>
</li>
@endif
<li class="nav-item dropdown ">
    <a href="#" class="nav-link has-dropdown"> <i class="fas fa-fire"></i><span>Daftar Cuti</span></a>
    <ul class="dropdown-menu">
           
        <li>
            <a class="nav-link" href="{{route('pengajuan_cuti.index')}}">Lihat Daftar Cuti</a>
            <li class="nav-item dropdown ">
        
        </li>
        
        <li>
        <a class="nav-link" href="{{route('pages.Cuti.ajukan')}}">pengajuan Cuti </a>
</li>
    </ul>
</li>

<li class="nav-item dropdown ">
    <a href="#" class="nav-link has-dropdown"> <i class="fas fa-fire"></i><span>Riwayat Cuti</span></a>
    <ul class="dropdown-menu">
           
        <li>
            <a class="nav-link" href="{{route('cuti.history')}}">History Cuti</a>
            <li class="nav-item dropdown ">
        
        </li>
        
        <li>
        <a class="nav-link" href="{{route('cutis.export')}}">Export to Excel </a>
</li>
    </ul>
</li> 
</li>
<li>   
</li>   
</li>

    </aside>
    



</div>
