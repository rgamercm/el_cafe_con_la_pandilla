<div class="mermaid">
graph TD;
    Cliente-->Solicitud;
    Solicitud-->Sistema;
    Sistema-->Inventario;
</div>
<script type="module">
  import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
  mermaid.initialize({ startOnLoad: true });
</script>