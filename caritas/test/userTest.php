public function testClassCadastro()
{
    $user = new User('Hevlla', 'doador', 'hevlla@gmail.com');

    $this->assertSame('Hevlla', $user->nome);
    $this->assertSame('instituicao', $user->opcao);
    $this->assertSame('hevlla@gmail.com', $user->email);

} 