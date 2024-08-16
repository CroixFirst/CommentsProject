<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Комментарии</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .comment {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s ease-in-out;
        }
        .comment:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .btn-custom {
            border-radius: 20px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            list-style-type: none;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 8px 16px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .pagination li a:hover,
        .pagination li span:hover {
            background-color: #e9ecef;
        }

        .pagination li.active span {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="text-center mb-5">Комментарии</h1>
    <div id="commentsList" class="mb-5">
        <?php foreach ($comments as $comment): ?>
            <div class="comment mb-4 p-4" data-id="<?= $comment['id']; ?>">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0"><?= esc($comment['name']); ?></h5>
                    <small class="text-muted"><?= date('d.m.Y H:i', strtotime($comment['created_at'])); ?></small>
                </div>
                <p class="mb-2"><?= esc($comment['comment']); ?></p>
                <small class="text-muted"><?= esc($comment['email']); ?></small>
                <button class="btn btn-sm btn-outline-danger float-right deleteComment" data-id="<?= $comment['id']; ?>">Удалить</button>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="d-flex justify-content-center mb-5">
        <?= $pager->links('default', 'default_full', ['path' => '']); ?>
    </div>
    <div class="text-center mb-5">
        <h5 class="mb-3">Сортировать по:</h5>
        <div class="btn-group" role="group" aria-label="Sort options">
            <a href="/comments/sort/id/asc" class="btn btn-custom btn-outline-primary">ID ↑</a>
            <a href="/comments/sort/id/desc" class="btn btn-custom btn-outline-primary">ID ↓</a>
            <a href="/comments/sort/created_at/asc" class="btn btn-custom btn-outline-primary">Дата ↑</a>
            <a href="/comments/sort/created_at/desc" class="btn btn-custom btn-outline-primary">Дата ↓</a>
        </div>
    </div>
    <div id="commentForm" class="bg-white p-4 rounded shadow-sm">
        <h4 class="mb-4">Добавить комментарий</h4>
        <form id="addCommentForm">
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div id="emailError" class="text-danger mt-2"></div>
            </div>
            <div class="form-group">
                <label for="comment">Комментарий</label>
                <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-custom">Добавить комментарий</button>
        </form>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#addCommentForm').submit(function(e){
        e.preventDefault();
        let email = $('#email').val();
        let emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
        
        if (!emailRegex.test(email)) {
            $('#emailError').text('Пожалуйста, введите корректный email-адрес');
            return;
        }

        $.ajax({
            url: 'http://localhost/comments/add',
            method: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response){
                if(response.status == 'success'){
                    location.reload();
                } else {
                    $('#emailError').text(response.errors.email);
                }
            }
        });
    });

    $('.deleteComment').click(function(){
        let commentId = $(this).data('id');
        
        $.ajax({
            url: 'http://localhost/comments/delete/' + commentId,
            method: 'post',
            dataType: 'json',
            success: function(response){
                if(response.status == 'success'){
                    location.reload();
                }
            }
        });
    });
});
</script>
</body>
</html>
