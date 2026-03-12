<?php

namespace App\Controllers;

use App\Models\RecordModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RecordController extends BaseController
{
    protected $model;

    // Load the RecordModel on controller initialization
    public function __construct()
    {
        $this->model = new RecordModel();
    }

    // READ — Show all records
    public function index()
    {
        $data['records'] = $this->model
            ->orderBy('created_at', 'DESC')
            ->findAll();
        return view('records/index', $data);
    }

    // CREATE — Show create form
    public function create()
    {
        return view('records/create');
    }

    // CREATE — Handle form submission
    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[3]',
            'description' => 'required',
            'category'    => 'required',
            'status'      => 'required|in_list[active,inactive]',
        ];

        // Validate inputs before saving
        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'category'    => $this->request->getPost('category'),
            'status'      => $this->request->getPost('status'),
        ]);

        return redirect()->to('/records')
            ->with('success', 'Record created successfully!');
    }

    // READ — Show single record detail
    public function show($id)
    {
        $data['record'] = $this->model->find($id);

        if (! $data['record']) {
            return redirect()->to('/records')
                ->with('error', 'Record not found.');
        }

        return view('records/show', $data);
    }

    // UPDATE — Show edit form with pre-populated data
    public function edit($id)
    {
        $data['record'] = $this->model->find($id);

        if (! $data['record']) {
            return redirect()->to('/records')
                ->with('error', 'Record not found.');
        }

        return view('records/edit', $data);
    }

    // UPDATE — Handle edit form submission
    public function update($id)
    {
        $rules = [
            'title'       => 'required|min_length[3]',
            'description' => 'required',
            'category'    => 'required',
            'status'      => 'required|in_list[active,inactive]',
        ];

        // Validate inputs before updating
        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'category'    => $this->request->getPost('category'),
            'status'      => $this->request->getPost('status'),
        ]);

        return redirect()->to('/records')
            ->with('success', 'Record updated successfully!');
    }

    // DELETE — Hard delete (permanently removes record from database)
    public function delete($id)
    {
        $record = $this->model->find($id);

        if (! $record) {
            return redirect()->to('/records')
                ->with('error', 'Record not found.');
        }

        $this->model->delete($id);

        return redirect()->to('/records')
            ->with('success', 'Record deleted successfully!');
    }
}