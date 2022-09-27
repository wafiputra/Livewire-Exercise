<?php

namespace App\Http\Livewire;

use App\Models\Student as ModelsStudent;
use Livewire\Component;
use Livewire\WithPagination;

class Student extends Component
{
    use WithPagination;
    public $name, $email, $course, $student_id;
    // public $students;
    protected $paginationTheme = 'bootstrap';

    public function saveStudent()
    {
        $validatedData = $this->validate();

        ModelsStudent::create($validatedData);
        session()->flash('message', 'Student Added Successfuly');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editStudent(int $student_id)
    {
        $student = ModelsStudent::find($student_id);
        if ($student) {
            $this->student_id = $student->id;
            $this->name = $student->name;
            $this->email = $student->email;
            $this->course = $student->course;
        } else {
            return redirect()->to('/students');
        }
    }

    public function updateStudent()
    {
        $validatedData = $this->validate();

        ModelsStudent::where('id', $this->student_id)->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'course' => $validatedData['course']
        ]);

        session()->flash('message', 'Student Updated Successfuly');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|min:6',
            'email' => ['required', 'email'],
            'course' => 'required|string',
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->course = '';
    }

    public function render()
    {
        $students = ModelsStudent::orderBy('id', 'DESC')->paginate(3);
        return view('livewire.student', ['students' => $students]);
    }
}
