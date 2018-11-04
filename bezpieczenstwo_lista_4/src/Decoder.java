import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Arrays;

import static java.util.Collections.frequency;

public class Decoder {

    ArrayList<ArrayList<String>> all;
    ArrayList<ArrayList<String>> bits;
    int[][] helper_array;


    public Decoder(){
        all = new ArrayList<>();
        bits = new ArrayList<>();
    }


    public void fill_helper_array(){
        int rows = all.size();
        int columns = find_max_width();
        int max;
        helper_array = new int[rows][columns];
        ArrayList<String> tmp;

        for(int i = 0; i < rows; i++){              //fill helper with zeros
            for(int j = 0; j < columns; j++){
                helper_array[i][j] = 0;
            }
        }

        for(int i = 0; i < all.size(); i++ ){               //check all pairs
            for(int j = i+1; j < all.size(); j++){
                tmp = xor_full_arrays(all.get(i),all.get(j));       //tmp = xor of each pair
                for(int k = 0; k < tmp.size(); k++){
                    if(if_potential_space(tmp.get(k))){             //for all bytes, check if potential space,
                        helper_array[i][k]++;                       // if so - increment helper
                        helper_array[j][k]++;
                    }
                }
            }
        }

        for(int i = 0; i < columns; i++){
            tmp = new ArrayList<String>();
            max = 0;
            for(int j = 0; j < rows; j++ ){         //find max in column
                if(helper_array[j][i] > max){
                    max = helper_array[j][i];
                }
            }

            if(max == 0){
                tmp.add("00000000");
                bits.add(tmp);
                continue;
            }

            for(int j = 0; j < rows; j++ ){         //add the most popular bits to array
                if(helper_array[j][i] == max){
                    tmp.add(all.get(j).get(i));
                }
            }
            bits.add(tmp);                          // list of list of potential spaces
        }

        print_using_key(get_key(bits));

    }

    public void print_using_key(ArrayList<String> key){
        for(ArrayList list : all){
            System.out.println(list_as_string(binary_list_to_ascii_list(xor_full_arrays(key,list))));
            System.out.println();
        }
    }

    public ArrayList<String> get_key(ArrayList<ArrayList<String>> bits){
        String space = "00100000";
        ArrayList<String> key = new ArrayList<>();

        for(int i = 0; i < bits.size(); i ++){
            for(int j = 0; j < bits.get(i).size(); j++){
                bits.get(i).set(j,xor(space,bits.get(i).get(j)));
            }
            key.add(most_popular(bits.get(i)));
        }

        return key;
    }

    public String most_popular(ArrayList<String> list){
        String result = "";
        int max = 0;
        for(int i = 0; i < list.size(); i++){
            if(frequency(list,list.get(i)) > max){
                result = list.get(i);
            }
        }
        return result;
    }


    public ArrayList xor_full_arrays(ArrayList<String> x, ArrayList<String> y){
        ArrayList<String> list = new ArrayList<>();
        int min = Math.min(x.size(),y.size());
        for(int i = 0; i < min; i++){
            list.add(xor(x.get(i),y.get(i)));
        }
        return list;
    }

    public String list_as_string(ArrayList<String> list){
        return String.join("", list);
    }

    public ArrayList<String> binary_list_to_ascii_list(ArrayList<String> list){
        ArrayList<String> result = new ArrayList<>();
        for(int i = 0; i < list.size(); i++){
            result.add(convert_binary_to_string_character(list.get(i)));
        }
        return result;
    }

    public String xor(String str1, String str2){
        String result = "";
        for(int i = 0; i < str1.length(); i++){
            if(str1.charAt(i) != (str2.charAt(i))){
                result = result + "1";
            }else{
                result = result + "0";
            }
        }
        return result;
    }

    public ArrayList<String> convert_string_to_binary_list(String string) {
        ArrayList<String> result = new ArrayList<>();
        int tmp;
        for(int i = string.length()-1; i >= 0; i--){
            tmp = (int)string.charAt(i);
            result.add(Integer.toBinaryString(tmp));
        }
        return result;
    }

    public String convert_binary_to_string_character(String binary){
        int number = Integer.parseInt(binary, 2);
        return Character.toString((char)number);
    }

    public boolean if_potential_space(String bits){
        if(bits.substring(0,2).equals("01")){
            return true;
        }else{
            return false;
        }
    }

    public int find_max_width(){
        int max = 0;
        for(int i = 0; i < all.size(); i ++){
            if(all.get(i).size() > max){
                max = all.get(i).size();
            }
        }
        return max;
    }

    // ************************************

    public void read(String filename){
        try(BufferedReader br = new BufferedReader(new FileReader(filename))) {
            String line = br.readLine();

            while (!line.equals("end")) {

                if(!line.equals("x")){
                    all.add(new ArrayList<>(Arrays.asList(line.split(" "))));
                }
                line = br.readLine();

            }

        } catch (FileNotFoundException e) {
            System.out.println("File reader failed");
        } catch (IOException e) {
            System.out.println("Reading line failed");
        }
    }
}
