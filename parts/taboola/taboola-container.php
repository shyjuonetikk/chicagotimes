<script type="text/javascript">
    window.page_counter++;
    taboola_container_id = 'taboola-below-article-thumbnails-' + page_counter;
    var taboolaDiv = document.createElement("div");
    taboolaDiv.id = taboola_container_id;
    var placeholder = jQuery('.taboola-container').last();
    placeholder.append( taboolaDiv );

    if( window.page_counter == 1 ) {
        window._taboola = window._taboola || [];
        _taboola.push({
            mode:'thumbnails-c', 
            container: taboola_container_id, 
            placement: 'Below Article Thumbnails', 
            target_type: 'mix'
        });
        _taboola.push({
            article:'auto', 
            url:''
        });
    }
</script>