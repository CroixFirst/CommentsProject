<?php

namespace App\Controllers;

use App\Models\CommentModel;
use CodeIgniter\Controller;

class Comments extends Controller
{
    public function index()
    {
        $commentModel = new CommentModel();
        $data['comments'] = $commentModel->orderBy('id', 'DESC')->paginate(3); // По 3 комментария на страницу
        $data['pager'] = $commentModel->pager;

        return view('comments_page', $data);
    }

    public function add()
    {
        $commentModel = new CommentModel();

        $validation =  \Config\Services::validation();
        $validation->setRule('email', 'Email', 'required|valid_email');

        if ($validation->withRequest($this->request)->run()) {
            $commentModel->save([
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'comment' => $this->request->getPost('comment'),
            ]);

            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'errors' => $validation->getErrors()]);
        }
    }

    public function delete($id)
    {
        $commentModel = new CommentModel();
        $commentModel->delete($id);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function sort($field, $direction)
    {
        $commentModel = new CommentModel();
        $data['comments'] = $commentModel->orderBy($field, $direction)->paginate(3);
        $data['pager'] = $commentModel->pager;

        return view('comments_page', $data);
    }
}
