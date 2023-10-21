<script>
    var canCopy = @can('order_product_copy') true @else false @endcan;
    var canEdit = @can('order_product_edit') true @else false @endcan;
    var canDelete = @can('order_product_delete') true @else false @endcan;
</script>
