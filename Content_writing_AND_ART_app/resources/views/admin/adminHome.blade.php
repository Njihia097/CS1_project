<x-admin-layout :artistCount="$artistCount" :contentCount="$contentCount">


@section('content')
<div>
    @include('admin/partials.body')
</div>
<script>
    

    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('artistContentChart').getContext('2d');
        var artistContentChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Artists', 'Content'],
                datasets: [{
                    label: '# of Items',
                    data: [{{ $artistCount }}, {{ $contentCount }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Artists vs Content'
                    }
                }
            }
        });
    });


  </script>
@endsection

</x-admin-layout>
