jQuery(document).ready(function(t){var a;t("#upload_image_button").click(function(e){e.preventDefault(),a||(a=wp.media.frames.file_frame=wp.media({title:"Choose Image",button:{text:"Choose Image"},multiple:!1})).on("select",function(){var e=a.state().get("selection").first().toJSON();t("#category-image").val(e.url),t("#category-image-preview").attr("src",e.url)}),a.open()})});