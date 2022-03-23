<!-- Modal -->
<div class="modal fade" id="{{$id}}" tabindex="-1" aria-labelledby="{{$id}}-label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="{{$id}}-label">{{$title}}</h5>
          <button type="button" class="btn-close {{$id}}-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="{{$id}}-body">
          {{$prompt}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary {{$id}}-btn" data-bs-dismiss="modal">Cancel</button>
          {{$button_action}}
        </div>
      </div>
    </div>
</div>