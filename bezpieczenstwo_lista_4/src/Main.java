public class Main {

    public static void main(String[] args) {

        Decoder decoder = new Decoder();
        decoder.read("dane.txt");

        decoder.fill_helper_array();
    }
}
