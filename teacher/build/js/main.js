$("#state_form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        action: 'submit_form',
        url: 'modules/states/request.php',
        data: form.serialize(), // serializes the form's elements.
        success: function (data)
        {
            //alert(data); // show response from the php script.
            var json = $.parseJSON(data);

            if (json.status === 'error') {
                toastr.error(json.errors)
                return false;
            }
            if (json.status === "success") {
                toastr.success(json.success)
                $('#state_form')[0].reset();
            }
        }
    });
});

$("#city_form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        action: 'submit_form',
        url: 'modules/cities/request.php',
        data: form.serialize(), // serializes the form's elements.
        success: function (data)
        {
            //alert(data); // show response from the php script.
            var json = $.parseJSON(data);

            if (json.status === 'error') {
                toastr.error(json.errors)
                return false;
            }
            if (json.status === "success") {
                toastr.success(json.success)
                $('#city_form')[0].reset();
            }
        }
    });
});

function get_city(id) {

    var dataString = 'id=' + id + '&action=fetch';

    $.ajax({
        type: "POST",
        url: 'modules/cities/get_cities.php',
        data: dataString,
        cache: false,
        success: function (data) {

            $('.city_id').html(data);
        }
    });
}

function get_students(school_id) {

    var errorMsg='';
    var class_id    =   $("#class_id").val();
    var section_id  =   $("#section_id").val();

    if(class_id==''){
        errorMsg   =   'Please Select Class';
        toastr.error('Please Select Class');
    }

    if(section_id==''){
        errorMsg   =   'Please Select Section';
        toastr.error('Please Select Section');
    }

    if(errorMsg==''){
        
        var dataString = 'school_id=' + school_id + '&class_id=' + class_id + '&section_id=' + section_id;
        $.ajax({
            type: "POST",
            url: 'modules/student/get_students.php',
            data: dataString,
            cache: false,
            success: function (data) {
                $('.student_id').html(data);
            }
        });
    }
}

function get_subjects(student_id) {
 
    var dataString = 'student_id=' + student_id;
    $.ajax({
        type: "POST",
        url: 'modules/student/get_subjects.php',
        data: dataString,
        cache: false,
        success: function (data) {
            $('.subject_id').html(data);
        }
    });
}

function change_status(id, value, url) {

    var dataString = 'id=' + id + '&status=' + value + '&action=change_status';
    $.ajax({
        type: "POST",
        url: url,
        data: dataString,
        cache: false,
        success: function (data) {
            var json = $.parseJSON(data);

            if (json.status === 'inactive') {
                toastr.success(json.success)

                $(".status_" + id).html('<span class="badge bg-danger" onclick="change_status(' + id + ', \'active\',\'' + url + '\')">Inactive</span>')
            }
            if (json.status === "active") {
                toastr.success(json.success)

                $(".status_" + id).html('<span class="badge bg-success" onclick="change_status(' + id + ', \'inactive\',\'' + url + '\')">Active</span>')
            }
        }
    });
}

function delete_detail(id, url) {

    var dataString = 'id=' + id + '&action=delete';

    var x = confirm("Are you sure you want to delete?");
    if (x) {
        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
            cache: false,
            success: function (data) {
                var json = $.parseJSON(data);
                if (json.status === 'success') {
                    toastr.success(json.success)
                    $(".row_" + id).fadeOut(500);
                }
            }
        });
    } else {
        return false;
    }
}


$("#class_form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        action: 'submit_form',
        url: 'modules/class/request.php',
        data: form.serialize(), // serializes the form's elements.
        success: function (data)
        {
            //alert(data); // show response from the php script.
            var json = $.parseJSON(data);

            if (json.status === 'error') {
                toastr.error(json.errors)
                return false;
            }
            if (json.status === "success") {
                toastr.success(json.success)
                $('#class_form')[0].reset();
            }
        }
    });
});

$("#section_form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        action: 'submit_form',
        url: 'modules/section/request.php',
        data: form.serialize(), // serializes the form's elements.
        success: function (data)
        {
            //alert(data); // show response from the php script.
            var json = $.parseJSON(data);

            if (json.status === 'error') {
                toastr.error(json.errors)
                return false;
            }
            if (json.status === "success") {
                toastr.success(json.success)
                $('#section_form')[0].reset();
            }
        }
    });
});

$("#subject_form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        action: 'submit_form',
        url: 'modules/subject/request.php',
        data: form.serialize(), // serializes the form's elements.
        success: function (data)
        {
            //alert(data); // show response from the php script.
            var json = $.parseJSON(data);

            if (json.status === 'error') {
                toastr.error(json.errors)
                return false;
            }
            if (json.status === "success") {
                toastr.success(json.success)
                $('#subject_form')[0].reset();
            }
        }
    });
});

$("#school_form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        action: 'submit_form',
        url: 'modules/school/request.php',
        data: form.serialize(), // serializes the form's elements.
        success: function (data)
        {
            //alert(data); // show response from the php script.
            var json = $.parseJSON(data);

            if (json.status === 'error') {
                toastr.error(json.errors)
                return false;
            }
            if (json.status === "success") {
                toastr.success(json.success)
                $('#school_form')[0].reset();
            }
        }
    });
});

// Edit Function fetch data using json
function view_school_detail(id) {
    var data = {
        "id": id,
        "action": 'view_detail'
    };
    data = $(this).serialize() + "&" + $.param(data);
    $.ajax({
        url: 'modules/school/request.php', //the script to call to get data          
        data: data, //you can insert url argumnets here to pass to api.php
        type: "POST", //for example "id=5&parent=6"
        dataType: 'json', //data format      
        success: function (data)          //on recieve of reply
        {
            //alert(data.detail[0].status);
            $('#modal-lg').modal('show');

            $('#school_id').html(data.detail[0].school_id);
            $('#name').html(data.detail[0].name);
            $('#principal_name').html(data.detail[0].principal_name);
            $('#school_found').html(data.detail[0].school_found);
            $('#email').html(data.detail[0].email);
            $('#mobile_no').html(data.detail[0].mobile_no);
            $('#address').html(data.detail[0].address);
            $('#state').html(data.detail[0].state);
            $('#city').html(data.detail[0].city);
            $('#dated').html(data.detail[0].dated);
            $('#status').html(data.detail[0].status);
        }
    });
}

$("#teacher_form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        action: 'submit_form',
        url: 'modules/teacher/request.php',
        data: form.serialize(), // serializes the form's elements.
        success: function (data)
        {
            //alert(data); // show response from the php script.
            var json = $.parseJSON(data);

            if (json.status === 'error') {
                toastr.error(json.errors)
                return false;
            }
            if (json.status === "success") {
                toastr.success(json.success)
                $('#teacher_form')[0].reset();
            }
        }
    });
});

// Edit Function fetch data using json
function view_teacher_detail(id) {
    var data = {
        "id": id,
        "action": 'view_detail'
    };
    data = $(this).serialize() + "&" + $.param(data);
    $.ajax({
        url: 'modules/teacher/request.php', //the script to call to get data          
        data: data, //you can insert url argumnets here to pass to api.php
        type: "POST", //for example "id=5&parent=6"
        dataType: 'json', //data format      
        success: function (data)          //on recieve of reply
        {
            //alert(data.detail[0].status);
            $('#modal-lg').modal('show');

            $('#school_name').html(data.detail[0].school_name);
            $('#name').html(data.detail[0].name);
            $('#email').html(data.detail[0].email);
            $('#qualification').html(data.detail[0].qualification);
            $('#experience').html(data.detail[0].experience);
            $('#subjects').html(data.detail[0].subjects);
            $('#mobile_no').html(data.detail[0].mobile_no);
            $('#address').html(data.detail[0].address);
            $('#state').html(data.detail[0].state);
            $('#city').html(data.detail[0].city);
            $('#dated').html(data.detail[0].dated);
            $('#status').html(data.detail[0].status);
        }
    });
}

$("#period_form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        action: 'submit_form',
        url: 'modules/period/request.php',
        data: form.serialize(), // serializes the form's elements.
        success: function (data)
        {
            //alert(data); // show response from the php script.
            var json = $.parseJSON(data);

            if (json.status === 'error') {
                toastr.error(json.errors)
                return false;
            }
            if (json.status === "success") {
                toastr.success(json.success)
                $('#period_form')[0].reset();
            }
        }
    });
});

function get_subjects_by_teacher(id) {

    var dataString = 'id=' + id + '&action=fetch';

    $.ajax({
        type: "POST",
        url: 'modules/teacher/get_subjects.php',
        data: dataString,
        cache: false,
        success: function (data) {
            //alert(data);
            $('.teacher_subjects').html(data);
        }
    });
}

$("#assign_class_form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        action: 'submit_form',
        url: 'modules/assign_class/request.php',
        data: form.serialize(), // serializes the form's elements.
        success: function (data)
        {
            //alert(data); // show response from the php script.
            var json = $.parseJSON(data);

            if (json.status === 'error') {
                toastr.error(json.errors)
                return false;
            }
            if (json.status === "success") {
                toastr.success(json.success)
                $('#assign_class_form')[0].reset();
            }
        }
    });
});

$("#student_form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        action: 'submit_form',
        url: 'modules/student/request.php',
        data: form.serialize(), // serializes the form's elements.
        success: function (data)
        {
            //alert(data); // show response from the php script.
            var json = $.parseJSON(data);

            if (json.status === 'error') {
                toastr.error(json.errors)
                return false;
            }
            if (json.status === "success") {
                toastr.success(json.success)
                $('#student_form')[0].reset();
            }
        }
    });
});

function view_student_detail(id) {
    var data = {
        "id": id,
        "action": 'view_detail'
    };
    data = $(this).serialize() + "&" + $.param(data);
    $.ajax({
        url: 'modules/student/request.php', //the script to call to get data          
        data: data, //you can insert url argumnets here to pass to api.php
        type: "POST", //for example "id=5&parent=6"
        dataType: 'json', //data format      
        success: function (data)          //on recieve of reply
        {
            //alert(data.detail[0].status);
            $('#modal-lg').modal('show');

            $('#school_name').html(data.detail[0].school_name);
            $('#name').html(data.detail[0].name);
            $('#email').html(data.detail[0].email);
            $('#qualification').html(data.detail[0].qualification);
            $('#experience').html(data.detail[0].experience);
            $('#subjects').html(data.detail[0].subjects);
            $('#mobile_no').html(data.detail[0].mobile_no);
            $('#address').html(data.detail[0].address);
            $('#state').html(data.detail[0].state);
            $('#city').html(data.detail[0].city);
            $('#dated').html(data.detail[0].dated);
            $('#status').html(data.detail[0].status);
            $('#father_name').html(data.detail[0].father_name);
            $('#mother_name').html(data.detail[0].mother_name);
            $('#class').html(data.detail[0].class);
            $('#dob').html(data.detail[0].dob);
        }
    });
}


function post_like(id) {
    var data = {
        "id": id,
        "action": 'post_like'
    };
    data = $(this).serialize() + "&" + $.param(data);
    $.ajax({
        url: 'modules/posts/like.php', //the script to call to get data          
        data: data, //you can insert url argumnets here to pass to api.php
        type: "POST", //for example "id=5&parent=6"
        dataType: 'json', //data format      
        success: function (data)          //on recieve of reply
        {
            //alert(data.status);
            if (data.msg == 'You Liked This Post') {
                toastr.success(data.msg);
                $('.like_counts_here').html('(' + data.likes + ') <i class="fas fa-thumbs-up"></i> Liked');

            } else if (data.msg == 'You Disliked This Post') {
                toastr.error(data.msg);
                $('.like_counts_here').html('(' + data.likes + ') <i class="far fa-thumbs-up mr-1"></i> Like');
            }

        }
    });
}

$("#comment_form").submit(function (event) {
    event.preventDefault();

    var comment_box = $("#comment_box").val();
    var post_id = $("#post_id").val();

    var data = {
        "post_id": post_id,
        "comment_box": comment_box,
        "action": 'post_comment'
    };
    data = $(this).serialize() + "&" + $.param(data);
    $.ajax({
        url: 'modules/posts/comment.php', //the script to call to get data          
        data: data, //you can insert url argumnets here to pass to api.php
        type: "POST", //for example "id=5&parent=6"
        dataType: 'text', //data format      
        success: function (data)          //on recieve of reply
        {
            //alert(data);
            toastr.success('You have commented on this Post');
            $('.post_comments').html(data);
            $("#comment_box").val('');


        }
    });

});

function get_comments(){

    var post_id = $("#post_id").val();

    var data = {
        "post_id": post_id,
        "action": 'get_comments'
    };
    data = $(this).serialize() + "&" + $.param(data);
    $.ajax({
        url: 'modules/posts/get_comments.php', //the script to call to get data          
        data: data, //you can insert url argumnets here to pass to api.php
        type: "POST", //for example "id=5&parent=6"
        dataType: 'text', //data format      
        success: function (data)          //on recieve of reply
        {
            //alert(data);
            $('.post_comments').html(data);


        }
    });
}
get_comments();

function delete_comment(post_comment_id,post_id) {
    var data = {
        "post_comment_id": post_comment_id,
        "post_id": post_id,
        "action": 'delete_comment'
    };
    data = $(this).serialize() + "&" + $.param(data);
    $.ajax({
        url: 'modules/posts/comment.php', //the script to call to get data          
        data: data, //you can insert url argumnets here to pass to api.php
        type: "POST", //for example "id=5&parent=6"
        dataType: 'text', //data format      
        success: function (data)          //on recieve of reply
        {
            toastr.success('Comment Deleted');
            $('.post_comments').html(data);

        }
    });
}

// $("#marks_form").submit(function (e) {

//     e.preventDefault(); // avoid to execute the actual submit of the form.
//     var form = $(this);
//     $.ajax({
//         type: "POST",
//         action: 'submit_form',
//         url: 'modules/marks/request.php',
//         data: form.serialize(), // serializes the form's elements.
//         success: function (data)
//         {
//             //alert(data); // show response from the php script.
//             var json = $.parseJSON(data);

//             if (json.status === 'error') {
//                 toastr.error(json.errors)
//                 return false;
//             }
//             if (json.status === "success") {
//                 toastr.success(json.success)
//                 $('#marks_form')[0].reset();
//             }
//         }
//     });
// });