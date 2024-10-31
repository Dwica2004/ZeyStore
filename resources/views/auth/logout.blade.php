<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Logout</button>
</form>
