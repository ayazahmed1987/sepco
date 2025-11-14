 <table class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
     <thead class="thead-dark">
         <tr>
             <th>No</th>
             <th>Ref No</th>
             <th>Title</th>
             <th>Technical Evaluation Published Date</th>
             <th>Technical Evaluation File</th>
             <th>Technical Evaluation File</th>
         </tr>
     </thead>
     <tbody>
         @forelse  ($technical_evaluations as $key => $technical_evaluation)
             @php
                 $tender = $technical_evaluation->tender;
             @endphp
             <tr>
                 <td>{{ ++$key }}</td>
                 <td>{{ $tender->ref_no }}</td>
                 <td>{{ $tender->title }}</td>
                 <td>{{ \Carbon\Carbon::parse($technical_evaluation->published_date)->format('d-m-Y') }}
                 </td>
                 <td>
                     {{ $technical_evaluation->financial_opening_date ? \Carbon\Carbon::parse($technical_evaluation->financial_opening_date)->format('d-m-Y') : 'N/A' }}
                 </td>
                 <td><a href="{{ asset(Storage::url($technical_evaluation->file)) }}" class="btn btn-dark"><i
                             class="fa fa-download"></i></a>
                 </td>
             </tr>
         @empty
             <tr>
                 <td colspan="6" class="text-center">No Technical Evaluations available.</td>
             </tr>
         @endforelse
     </tbody>
 </table>
 {{ $technical_evaluations->links('pagination::bootstrap-5') }}
