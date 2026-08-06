<div class="login">
    <div class="card shadow">
        <div class="card-header text-center">
            <img src="./imgs/logoKaeru.png" alt="Logo Kaeru">
        </div>
        <div class="card-body">
            <form name="formLogin" method="post" data-parsley-validate>
                <label for="email">E-Mail:</label>
                <input type="email" name="email" id="email" required
                data-parsley-required-message="Preencha esse campo"
                data-parsley-type-message="Digite um E-Mail válido"
                class="form-control">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required
                data-parsley-required-message="Preencha esse campo"
                class="form-control">
                <br>
                <button type="submit" class="btn btn-success w-100">
                    Realizar Login
                </button>
            </form>
        </div>
    </div>
</div>