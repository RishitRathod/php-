<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>PHP - AJAX - CRUD</title>
</head>
<body>


    <!-- Edit Modal -->
    <div class="modal fade" id="StudentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Student Data without page reload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="id_edit">

                        <div class="col-md-12">
                            <div class="error-message">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">First Name</label>
                            <input type="text" id="edit_fname" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="">Last Name</label>
                            <input type="text" id="edit_lname" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="">Class</label>
                            <input type="text" id="edit_class" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="">Section</label>
                            <input type="text" id="edit_section" class="form-control">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary student_update_ajax">Update</button>
            </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            PHP - AJAX - CRUD | Data without page reload using jquery ajax in php.
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#Student_AddModal">
                                Add
                            </button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="message-show">

                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="studentdata">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            getdata();
        });

        function getdata()
        {
            $.ajax({
                type: "GET",
                url: "fetch.php",
                success: function (response) {
                    // console.log(response);
                    $.each(response, function (key, value) { 
                        // console.log(value['fname']);
                        $('.studentdata').append('<tr>'+
                                '<td class="stud_id">'+value['id']+'</td>\
                                <td>'+value['fname']+'</td>\
                                <td>'+value['lname']+'</td>\
                                <td>'+value['class']+'</td>\
                                <td>'+value['section']+'</td>\
                                <td>\
                                    <a href="" class="badge btn-primary edit_btn">EDIT</a>\
                                    <a href="" class="badge btn-danger">Delete</a>\
                                </td>\
                            </tr>');
                    });
                }
            });
        }



        $(document).ready(function () {

getdata();

$('.student_add_ajax').click(function (e) { 
    e.preventDefault();
    
    var fname = $('.fname').val();
    var lname = $('.lname').val();
    var stu_class = $('.class').val();
    var section = $('.section').val();

    if(fname != '' & lname !='' & stu_class !='' & section !='')
    {
        $.ajax({
            type: "POST",
            url: "code.php",
            data: {
                'checking_add':true,
                'fname': fname,
                'lname': lname,
                'class': stu_class,
                'section': section,
            },
            success: function (response) {
                // console.log(response);
                $('#Student_AddModal').modal('hide');
                $('.message-show').append('\
                    <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>\
                    </div>\
                ');
                $('.studentdata').html("");
                getdata();
                $('.fname').val("");
                $('.lname').val("");
                $('.class').val("");
                $('.section').val("");
            }
        });

    }
    else
    {
        // console.log("Please enter all fileds.");
        $('.error-message').append('\
            <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please enter all fileds.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                    <span aria-hidden="true">&times;</span>\
                </button>\
            </div>\
        ');
    }
    
});
});






        $(document).ready(function () {
            getdata();

            $(document).on("click", ".edit_btn", function () {

                var stud_id = $(this).closest('tr').find('.stud_id').text();
                // alert(stud_id);

                $.ajax({
                    type: "POST",
                    url: "code2.php",
                    data: {
                        'checking_edit': true,
                        'stud_id': stud_id,
                    },
                    success: function (response) {
                        // console.log(response);
                        $.each(response, function (key, studedit) { 
                            // console.log(studview['fname']);
                            $('#id_edit').val(studedit['id']);
                            $('#edit_fname').val(studedit['fname']);
                            $('#edit_lname').val(studedit['lname']);
                            $('#edit_class').val(studedit['class']);
                            $('#edit_section').val(studedit['section']);
                        });
                        $('#StudentEditModal').modal('show');
                    }
                });

            });
           
        });




    </script>




  </body>
</html>