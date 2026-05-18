    </main>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
function toggleSidebar(){document.getElementById('sidebar').classList.toggle('open');document.getElementById('sidebarOverlay').classList.toggle('active');}
$(document).ready(function(){if($('.datatable').length){$('.datatable').DataTable({language:{url:'//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'},pageLength:10,responsive:true});}});
function confirmDelete(url,name){if(confirm('Hapus "'+name+'"?'))window.location.href=url;}
</script>
<?php if(isset($extraScript)):?><script><?=$extraScript?></script><?php endif;?>
</body>
</html>
