<h2>Tworzenie ticketu</h2>

<form method="post" action="/zadanie15/parts/client-create-ticket-handle.php">
    <div class="form-group">
        <label for="ticket-create-kind">Rodzaj ticketu</label>
        <select name="ticket-create-kind" id="ticket-create-kind" class="form-control" required>
            <option value="Prośba o pomoc techniczną">Prośba o pomoc techniczną</option>
            <option value="Żądanie dostępu do zasobów">Żądanie dostępu do zasobów</option>
            <option value="Aktualizacja oprogramowania lub OS">Aktualizacja oprogramowania lub OS</option>
            <option value="Prośba o szkolenie lub wsparcie szkoleniowe">Prośba o szkolenie lub wsparcie szkoleniowe</option>
            <option value="Zgłoszenie problemu z bezpieczeństwem">Zgłoszenie problemu z bezpieczeństwem</option>
        </select>
    </div>

    <div class="form-group">
        <label for="ticket-create-content">Treść ticketu</label>
        <textarea name="ticket-create-content" id="ticket-create-content" class="form-control" required></textarea>
    </div>

    <input type="submit" value="Prześlij ticket" class="btn btn-success btn-sm" />
</form>