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

$("#year_form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        action: 'submit_form',
        url: 'modules/year/request.php',
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
                $('#year_form')[0].reset();
            }
        }
    });
});