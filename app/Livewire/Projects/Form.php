<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Form extends Component
{
    use WithFileUploads;

    public $project;
    public $projectId;
    public $title;
    public $slug;
    public $description;
    public $image;
    public $existingImage;
     public $video_url;
    // public $technologies;
    // public $is_featured = false;
    // public $completion_date;
    // public $order = 0;
    // public $technologiesString = '';
    public $autoUpdateSlug = true;

    protected $listeners = ['refreshProjectForm' => '$refresh'];

    protected function rules()
    {
        $slugRule = 'required|string|max:255|unique:projects,slug';

        if ($this->projectId) {
            $slugRule .= ',' . $this->projectId;
        }

        return [
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url|max:255',
            // 'technologiesString' => 'nullable|string',
            // 'is_featured' => 'boolean',
            // 'completion_date' => 'nullable|date',
            // 'order' => 'integer|min:0'
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->projectId = $id;
            $this->project = Project::findOrFail($id);
            $this->title = $this->project->title;
            $this->slug = $this->project->slug;
            $this->description = $this->project->description;
            $this->existingImage = $this->project->image;
          //  $this->url = $this->project->url;
            $this->video_url = $this->project->video_url;
            // $this->is_featured = $this->project->is_featured;
            // $this->completion_date = $this->project->completion_date ? $this->project->completion_date->format('Y-m-d') : null;
            // $this->order = $this->project->order;

            // if ($this->project->technologies) {
            //     $this->technologiesString = implode(', ', $this->project->technologies);
            // }
        }
    }

    public function updatedTitle()
    {
        if ($this->autoUpdateSlug) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function updatedSlug()
    {
        $this->slug = Str::slug($this->slug);
        $this->autoUpdateSlug = false;
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
        $this->autoUpdateSlug = true;
    }

    public function removeImage()
    {
        if ($this->existingImage) {
            Storage::disk('public')->delete($this->existingImage);

            if ($this->projectId) {
                Project::find($this->projectId)->update([
                    'image' => null
                ]);
            }

            $this->existingImage = null;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'video_url' => $this->video_url,
            // 'is_featured' => $this->is_featured,
            // 'completion_date' => $this->completion_date,
            // 'order' => $this->order
        ];

        // Process technologies as an array
        // if (!empty($this->technologiesString)) {
        //     $technologies = explode(',', $this->technologiesString);
        //     $data['technologies'] = array_map('trim', $technologies);
        // } else {
        //     $data['technologies'] = [];
        // }

        // Handle image upload
        if ($this->image) {
            // Delete old image if exists
            if ($this->projectId && $this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }

            $imagePath = $this->image->store('projects', 'public');
            $data['image'] = $imagePath;
        }

        if ($this->projectId) {
            Project::find($this->projectId)->update($data);
            session()->flash('message', 'Project updated successfully!');
        } else {
            Project::create($data);
            session()->flash('message', 'Project created successfully!');
        }

        return redirect()->route('projects.index');
    }

    public function render()
    {
        $title = $this->projectId ? 'Edit Project' : 'Create Project';
        return view('livewire.projects.form')->layout('components.layouts.app', ['title' => $title]);
    }
}
