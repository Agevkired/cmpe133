    function myFunction() {
        $.post('forumFunctions.php', { allForums: true }, function(data) {
                    $('#content').empty()
                    $.each(data, function() {
                        $('#content').append('<p class=\'topic_blocks\'><b>Title: <a href="view_thread.php?fid=' 
                            + this.id + '">' 
                            + this.title 
                            + '</a></b><br>By: ' 
                            + this.createdBy
                            + '<br>Created: '
                            + this.createdAt
                            + '<br>Last Updated: '
                            + this.updatedAt
                            + '</li>');
                    });
                }, "json");
    }

    $(document).ready(function() {

        $('#keyword').on('input', function() {
            var searchKeyword = $(this).val();
            if (searchKeyword.length >= 3) {
                $.post('forumFunctions.php', { keywords: searchKeyword }, function(data) {
                    $('#content').empty()
                    $.each(data, function() {
                        $('#content').append('<p class=\'topic_blocks\'><b>Title: <a href="view_thread.php?fid=' 
                            + this.id + '">' 
                            + this.title 
                            + '</a></b><br>By: ' 
                            + this.createdBy
                            + '<br>Created: '
                            + this.createdAt
                            + '<br>Last Updated: '
                            + this.updatedAt
                            + '</li>');
                    });
                }, "json");
            }else if(searchKeyword.length == 0){//added
                    $.post('forumFunctions.php', { allForums: true }, function(data) {
                    $('#content').empty()
                    $.each(data, function() {
                        $('#content').append('<p class=\'topic_blocks\'><b>Title: <a href="view_thread.php?fid=' 
                            + this.id + '">' 
                            + this.title 
                            + '</a></b><br>By: ' 
                            + this.createdBy
                            + '<br>Created: '
                            + this.createdAt
                            + '<br>Last Updated: '
                            + this.updatedAt
                            + '</li>');
                    });
                }, "json");
            }//added
            
        });
    });

    $(function(){
      myFunction();
    });