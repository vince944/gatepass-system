@php
    $cwsJsonUrl = $coordinatorWorkspaceJsonUrl ?? route('admin.coordinator.index');
    $cwsSearchParam = $coordinatorWorkspaceSearchParam ?? 'search';
    $cwsEmbed = ($coordinatorWorkspaceEmbedMode ?? 'coordinator') === 'admin';
@endphp
<script>
    (() => {
        const CWS_JSON_URL = @json($cwsJsonUrl);
        const CWS_SEARCH_PARAM = @json($cwsSearchParam);
        const CWS_EMBED_ADMIN = @json($cwsEmbed);
        @include('partials.coordinator-workspace-script-body')
    })();
</script>
