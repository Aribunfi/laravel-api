<table class="table">
    <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Year</th>
            <th scope="col">Kind</th>
            <th scope="col">Time</th>
            <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($projects as $project)
        <tr>
            <th scope="row">{{ $project->id }}</th>
            <td>{{ $project->title }}</td>
            <td>{{ $project->year }}</td>
            <td>{{ $project->kind }}</td>
            <td>{{ $project->time }}</td>
            <td>{{ $project->description }}</td>
            <td>...</td>

            @forelse($project->technology as $technology)
            {{ $technology->label}} @unless
            ($loop->last) , @else .
            @endunless
                
            @empty
                
            @endforelse
        </tr>
        <a href="{{ route('projects.show', $project) }}"> Dettaglio </a>
        <a href="{{ route('projects.create') }}" role="button" class="btn btn-primary">Crea progetto</a>
        <a href="{{ route('projects.edit', $project) }}">Modifica</a>
       
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $project->id }}">
            Elimina              
          </button>
       
        @endforeach
    </tbody>
</table>


@foreach ($projects as $project)
  <!-- Modal -->
  <div class="modal fade" id="delete-modal-{{ $project->id }}" tabindex="-1" aria-labelledby="delete-modal-{{ $project->id }}-label"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="delete-modal-{{ $project->id }}-label">Conferma eliminazione</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">
          Sei sicuro di voler eliminare il progetto {{ $project->title }} Year {{ $project->year }} con ID
          {{ $project->id }}? <br>
          L'operazione non è reversibile
        </div>

        <label class="form-label">Tags</label>

<div class="form-check @error('technologies') is-invalid @enderror p-0">
  @foreach ($technologies as $technology)
    <input
      type="checkbox"
      id="technology-{{ $technology->id }}"
      value="{{ $technology->id }}"
      name="technologies[]"
      class="form-check-control"
      @if (in_array($technology->id, old('technologies', $project_technology ?? []))) checked @endif
    >
    <label for="technology-{{ $technology->id }}">
      {{ $technology->label }}
    </label>
    <br>
  @endforeach
</div>

@error('technologies')
  <div class="invalid-feedback">
    {{ $message }}
  </div>
@enderror







        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

          <form action="{{ route('projects.destroy', $project) }}" method="POST" class="">
            @method('DELETE')
            @csrf

            <button type="submit" class="btn btn-danger">Elimina</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endforeach

{{-- Se è stata usata la paginazione --}}
{{ $projects->links('pagination::bootstrap-5') }}